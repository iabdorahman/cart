<?php

namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $cart = new Cart(session()->get('cart'));
        $cart->remove($product->id);
        if($cart->totalQty <= 0){
            session()->forget('cart');
        }
        else{
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.show')->with('success', 'Product removed successfully');

    }

    public function addToCart(Product $product){
        if(session()->has('cart')){
            $cart = new Cart(session()->get('cart'));
        } else {
            $cart = new Cart(); // return null
        }
        $cart->add($product);
        // dd($cart);
        session()->put('cart', $cart);
        return redirect()->route('product.index')->with('success', 'Product added successfully');
    }

    public function showCart() {
        if(session()->has('cart')){
            $cart = new Cart(session()->get('cart'));
        } else {
            $cart = null; // return null.
        }
        return view('cart.show', compact('cart'));
    }

    public function checkout($amount) {
        return view('cart.checkout', compact('amount'));
    }

    public function charge(Request $request) {
        // dd($request->stripeToken);
        $charge = Stripe::charges()->create([
            'currency' => 'USD',
            'source' => $request->stripeToken,
            'amount' => $request->amount,
            'description' => 'Test payment',
        ]);

        $chargeId = $charge['id'];

        // save order in orders table
        auth()->user()->orders()->create([
            'cart' => serialize(session()->get('cart')),
        ]);

        // delete products from cart session
        if($chargeId){
            session()->forget('cart');
            return redirect('store')->with('success', 'Your payment successfully done.');
        } else {
            return redirect('store')->back()->with('failed', 'Your payment not done, please check again and retry.');
        }


        // return view('cart.charge', compact('amount'));

    }

    public function updateQty(Request $request, Product $product){
        $request->validate([
            'qty' => 'required|numeric|min:1',
        ]);

        $cart = new Cart(session()->get('cart'));
        $cart->changeQty($product->id, $request->qty);
        session()->put('cart', $cart);
        return redirect()->route('cart.show')->with('seccess', 'Product quantity has been updated.');
    }
}
