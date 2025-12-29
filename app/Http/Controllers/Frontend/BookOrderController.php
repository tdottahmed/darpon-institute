<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\NewUserPasswordMail;
use App\Models\Book;
use App\Models\BookOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'quantity' => 'required|integer|min:1',
            'shipping_method' => 'required|in:inside_dhaka,outside_dhaka',
        ]);

        $shippingCost = $request->shipping_method === 'inside_dhaka' ? 60 : 120;
        $price = ($book->discount > 0) 
            ? $book->price - ($book->price * ($book->discount / 100)) 
            : $book->price;
            
        $totalAmount = ($price * $request->quantity) + $shippingCost;

        try {
            return DB::transaction(function () use ($request, $book, $shippingCost, $price, $totalAmount) {
                $user = Auth::user();
                $isNewUser = false;
                $password = null;

                if (!$user) {
                    $user = User::where('email', $request->email)->first();

                    if (!$user) {
                        // Create new user
                        $password = \Illuminate\Support\Str::random(10);
                        $user = User::create([
                            'name' => $request->name,
                            'email' => $request->email,
                            'password' => Hash::make($password),
                            'user_type' => 'customer',
                        ]);
                        $isNewUser = true;

                        // Send email (mandatory, failure rolls back transaction)
                        try {
                            Mail::to($user->email)->send(new NewUserPasswordMail($user, $password));
                        } catch (\Exception $mailException) {
                            logger()->error($mailException->getMessage());
                            throw new \Exception('Failed to send email. Please check your email address and try again.');
                        }

                        Auth::login($user);
                    }
                }

                $bookOrder = BookOrder::create([
                    'book_id' => $book->id,
                    'user_id' => $user ? $user->id : null,
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

                // Load relationships for the invoice
                $bookOrder->load('book', 'user');

                // Return the order data to show invoice inline
                return Inertia::render('Books/Checkout', [
                    'book' => $book,
                    'order' => $bookOrder,
                    'isNewUser' => $isNewUser,
                ]);
            });
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to place order. Please try again. ' . $e->getMessage());
        }
    }
}
