<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index(Request $request)
    {
        // $orders =  $this->order->getWithPaginateBy(auth()->user()->id);
        $orders = $this->order->latest('id')->paginate(10);
        if ($request->has('keyword') && $request->input('keyword') !== '') {
            $keyword = $request->input('keyword');
            $orders = $this->order->search($keyword)->latest('id')->paginate(5);
        }
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order =  $this->order->findOrFail($id);
        $order->update(['status' => $request->status]);
        return  response()->json([
            'message' => 'success'
        ], Response::HTTP_OK);
    }
}
