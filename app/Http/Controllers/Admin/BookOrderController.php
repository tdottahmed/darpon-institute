<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookOrder;
use Illuminate\Http\Request;

class BookOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = BookOrder::with('book')->latest()->paginate(10);
        return view('admin.book_orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(BookOrder $bookOrder)
    {
        $bookOrder->load('book');
        return view('admin.book_orders.show', compact('bookOrder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookOrder $bookOrder)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $bookOrder->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookOrder $bookOrder)
    {
        $bookOrder->delete();
        return redirect()->route('admin.book-orders.index')->with('success', 'Order deleted successfully.');
    }
}
