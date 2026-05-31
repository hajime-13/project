<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'product_name'  => 'required|string|max:255',
            'quantity'      => 'required|integer|min:1',
            'price'         => 'required|numeric|min:0',
            'status'        => 'required|in:Pending,Processing,Completed,Cancelled',
            'notes'         => 'nullable|string|max:500',
        ]);

        Order::create([
            'user_id'       => Auth::id(),
            'customer_name' => $request->customer_name,
            'product_name'  => $request->product_name,
            'quantity'      => $request->quantity,
            'price'         => $request->price,
            'status'        => $request->status,
            'notes'         => $request->notes,
        ]);

        return redirect()->route('orders.index')
            ->with('toast_success', 'Order for "' . $request->customer_name . '" added successfully.');
    }

    public function edit(Order $order)
    {
        // Ensure user can only edit their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'product_name'  => 'required|string|max:255',
            'quantity'      => 'required|integer|min:1',
            'price'         => 'required|numeric|min:0',
            'status'        => 'required|in:Pending,Processing,Completed,Cancelled',
            'notes'         => 'nullable|string|max:500',
        ]);

        $order->update($request->only(
            'customer_name', 'product_name', 'quantity', 'price', 'status', 'notes'
        ));

        return redirect()->route('orders.index')
            ->with('toast_success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        $order->delete();
        return redirect()->route('orders.index')
            ->with('toast_success', 'Order deleted successfully.');
    }
}
