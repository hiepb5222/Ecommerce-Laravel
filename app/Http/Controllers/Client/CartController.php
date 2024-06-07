<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\CreateOrderRequest;
use App\Http\Resources\Cart\CartResource;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session as Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $cart;
    protected $product;
    protected $cartProduct;
    protected $coupon;
    protected $order;

    public function __construct(Product $product, Cart $cart, CartProduct $cartProduct, Coupon $coupon, Order $order)
    {
        $this->product = $product;
        $this->cart = $cart;
        $this->cartProduct = $cartProduct;
        $this->coupon = $coupon;
        $this->order = $order;
    }

    public function index()
    {
        $cart = $this->cart->firstOrCreateBy(auth()->user()->id)->load('products');

        return view('client.carts.index', compact('cart'));
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


        if ($request->product_size) {
            $product = $this->product->findOrFail($request->product_id);
            $cart = $this->cart->firstOrCreateBy(auth()->user()->id);
            $cartProduct = $this->cartProduct->getBy($cart->id, $product->id, $request->product_size);
            if ($cartProduct) {
                $quanlity = $cartProduct->product_quantity;
                $cartProduct->update(['product_quantity' => ($quanlity + $request->product_quantity)]);
            } else {
                $dataCreate['cart_id'] = $cart->id;
                $dataCreate['product_size'] = $request->product_size;
                $dataCreate['product_quantity'] = $request->product_quantity ?? 1;
                $dataCreate['product_price'] = $request->product_price;
                $dataCreate['product_id'] = $request->product_id;
                $this->cartProduct->create($dataCreate);
            }
            return back()->with(['message' => 'Them thanh cong']);
        } else {
            return back()->with(['message' => 'Ban chua chon size']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateQuantityProduct(Request $request, $id)
    {
        $cartProduct =  $this->cartProduct->find($id);
        $dataUpdate = $request->all();
        if ($dataUpdate['product_quantity'] < 1) {
            $cartProduct->delete();
        } else {
            $cartProduct->update($dataUpdate);
        }

        $cart =  $cartProduct->cart;

        return response()->json([
            'product_cart_id' => $id,
            'cart' => new CartResource($cart),
            'remove_product' => $dataUpdate['product_quantity'] < 1,
            'cart_product_price' => $cartProduct->total_price
        ], Response::HTTP_OK);
    }
    public function removeProductInCart($id)
    {
        $cartProduct =  $this->cartProduct->find($id);
        $cartProduct->delete();
        $cart =  $cartProduct->cart;
        return response()->json([
            'product_cart_id' => $id,
            'cart' => new CartResource($cart)
        ], Response::HTTP_OK);
    }

    public function applyCoupon(Request $request)
    {
        $name = $request->input('coupon_name');
        $coupon = $this->coupon->firstWithExpiryDate($name, auth()->user()->id);
        

        if ($coupon) {
            $message = "Successfully applied coupon";
            Session::put('coupon_id', $coupon->id);
            Session::put('discount_amount_price', $coupon->value);
            Session::put('coupon_code', $coupon->name);
        } else {
            Session::forget(['coupon_id', 'discount_amount_price','coupon_code']);
            $message = "Failed to apply coupon";
        }
        return redirect()->route('client.carts.index')->with(['message' => $message, 'coupon' => $coupon]);
    }

    public function checkout()
    {
        $cart = $this->cart->firstOrCreateBy(auth()->user()->id)->load('products');
        return view('client.carts.checkout', compact('cart'));
    }

    public function processCheckout(CreateOrderRequest $request)
    {

        $dataCreate = $request->all();
        $dataCreate['user_id'] = auth()->user()->id;
        $dataCreate['status'] = 'pending';
        $this->order->create($dataCreate);
        $couponID = Session::get('coupon_id');
        if ($couponID) {
            $coupon =  $this->coupon->find(Session::get('coupon_id'));
            if ($coupon) {
                $coupon->users()->attach(auth()->user()->id, ['value' => $coupon->value]);
            }
        }
        $cart = $this->cart->firstOrCreateBy(auth()->user()->id);
        $cart->products()->delete();
        Session::forget(['coupon_id', 'discount_amount_price', 'coupon_code']);
        return redirect()->route('client.orders.index');

    }
}
