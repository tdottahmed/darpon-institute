<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookOrder;
use App\Models\CourierOrderHistory;
use App\Services\CourierFraudCheckerService;
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
        $fraudCheckHistory = CourierOrderHistory::where('phone', $bookOrder->phone)->latest()->first();

        return view('admin.book_orders.show', compact('bookOrder', 'fraudCheckHistory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookOrder $bookOrder)
    {
        $request->validate([
            'status' => 'nullable|string|in:pending,processing,shipped,delivered,cancelled',
            'name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'create_consignment' => 'nullable|boolean',
        ]);

        // Update Order Details if provided
        $updateData = [];
        if ($request->has('status')) {
            $updateData['status'] = $request->status;
        }
        if ($request->has('name')) {
            $updateData['name'] = $request->name;
        }
        if ($request->has('address')) {
            $updateData['address'] = $request->address;
        }
        if ($request->has('phone')) {
            $updateData['phone'] = $request->phone;
        }

        if (!empty($updateData)) {
            $bookOrder->update($updateData);
        }

        // Create Consignment if requested
        if ($request->create_consignment) {
            // Check if API credentials are configured
            $apiKey = \App\Models\Setting::get('steadfast_api_key') ?: config('steadfast-courier.api_key');
            $secretKey = \App\Models\Setting::get('steadfast_secret_key') ?: config('steadfast-courier.secret_key');
            
            if (empty($apiKey) || empty($secretKey) || $apiKey === 'your-api-key' || $secretKey === 'your-secret-key') {
                return redirect()->back()->with('error', 'Steadfast API credentials are not configured. Please configure them in Settings > General Settings.');
            }

            // Update Order Details
            $bookOrder->update([
                'name' => $request->name ?? $bookOrder->name,
                'address' => $request->address ?? $bookOrder->address,
                'phone' => $request->phone ?? $bookOrder->phone,
            ]);

            // Create Consignment
            try {
                // Ensure config is updated from database
                config([
                    'steadfast-courier.api_key' => $apiKey,
                    'steadfast-courier.secret_key' => $secretKey,
                ]);

                $courierData = [
                    'invoice' => (string) $bookOrder->id,
                    'recipient_name' => $bookOrder->name,
                    'recipient_phone' => $bookOrder->phone,
                    'recipient_address' => $bookOrder->address,
                    'cod_amount' => $bookOrder->total_amount, // Assuming COD amount is total
                    'note' => $bookOrder->note ?? 'Order #' . $bookOrder->id,
                ];

                $response = \SteadFast\SteadFastCourierLaravelPackage\Facades\SteadfastCourier::placeOrder($courierData);

                if (isset($response['status']) && $response['status'] == 200) {
                    // Consignment created successfully
                    $consignmentData = [
                        'consignment_created_at' => now(),
                    ];

                    // Save consignment_id or tracking_code if available in response
                    if (isset($response['consignment']['consignment_id'])) {
                        $consignmentData['consignment_id'] = $response['consignment']['consignment_id'];
                    }
                    if (isset($response['consignment']['tracking_code'])) {
                        $consignmentData['tracking_code'] = $response['consignment']['tracking_code'];
                    } elseif (isset($response['consignment']['invoice'])) {
                        $consignmentData['tracking_code'] = $response['consignment']['invoice'];
                    }

                    $bookOrder->update($consignmentData);

                    return redirect()->back()->with('success', 'Consignment created successfully!');
                } else {
                    $errorMessage = 'Failed to create consignment with Steadfast.';
                    if (isset($response['message'])) {
                        $errorMessage = 'Steadfast Error: ' . (is_array($response['message']) ? json_encode($response['message']) : $response['message']);
                    }
                    if (isset($response['status'])) {
                        $errorMessage .= ' (Status: ' . $response['status'] . ')';
                    }
                    return redirect()->back()->with('error', $errorMessage);
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Steadfast Exception: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Order updated successfully.');
    }

    /**
     * Display invoice for the book order.
     */
    public function invoice(BookOrder $bookOrder)
    {
        $bookOrder->load('book');
        return view('admin.book_orders.invoice', compact('bookOrder'));
    }

    /**
     * Check fraud for the order's phone number.
     */
    public function checkFraud(BookOrder $bookOrder)
    {
        if (!$bookOrder->phone) {
            return redirect()->back()->with('error', 'Phone number is required for fraud check.');
        }

        $fraudCheckerService = new CourierFraudCheckerService();
        $history = $fraudCheckerService->check($bookOrder->phone);

        if ($history) {
            return redirect()->back()->with('success', 'Fraud check completed.')->with('fraudCheckData', $history);
        } else {
            return redirect()->back()->with('error', 'Failed to check fraud. Please try again.');
        }
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
