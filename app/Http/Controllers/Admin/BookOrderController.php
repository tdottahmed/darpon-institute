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
    public function index(Request $request)
    {
        $query = BookOrder::with('book');

        // Search filter
        if ($request->filled('search')) {
            $search = trim($request->search);
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhereHas('book', function ($bookQuery) use ($search) {
                            $bookQuery->where('title', 'like', "%{$search}%");
                        });
                });
            }
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Book filter
        if ($request->filled('book_id')) {
            $query->where('book_id', $request->book_id);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();
        $books = \App\Models\Book::orderBy('title')->pluck('title', 'id');

        return view('admin.book_orders.index', compact('orders', 'books'));
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
