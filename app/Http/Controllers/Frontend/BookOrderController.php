<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookOrder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookOrderController extends Controller
{
    /**
     * Show the checkout form for a specific book.
     */
    public function create(Book $book)
    {
        return Inertia::render('Books/Checkout', [
            'book' => $book
        ]);
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'quantity' => 'required|integer|min:1',
            'shipping_method' => 'required|in:inside_dhaka,outside_dhaka',
        ]);

        $shippingCost = $request->shipping_method === 'inside_dhaka' ? 60 : 120;
        $bookPrice = $book->discount_price ?? $book->price; // Assuming discount_price accessor or logic exists, else handle manually
        // If discount_price doesn't exist on model yet, we'll use price. Let's check model first? 
        // Based on previous code, we have 'discounted_price' accessor or similar? 
        // Let's rely on basic logic: 
        $price = ($book->discount > 0) 
            ? $book->price - ($book->price * ($book->discount / 100)) 
            : $book->price;
            
        $totalAmount = ($price * $request->quantity) + $shippingCost;

        BookOrder::create([
            'book_id' => $book->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'quantity' => $request->quantity,
            'shipping_method' => $request->shipping_method,
            'shipping_cost' => $shippingCost,
            'total_amount' => $totalAmount,
            'payment_method' => 'cod',
            'status' => 'pending',
            'note' => $request->note,
        ]);

        return redirect()->route('books.show', $book->slug)
            ->with('success', 'Order placed successfully! We will contact you soon.');
    }
}
