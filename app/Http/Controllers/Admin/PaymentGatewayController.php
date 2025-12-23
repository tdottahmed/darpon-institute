<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentGateways = PaymentGateway::orderBy('order')->orderBy('name')->paginate(10);
        return view('admin.payment_gateways.index', compact('paymentGateways'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payment_gateways.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:bkash,nagad,rocket,bank',
            'account_number' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'status' => 'boolean',
        ]);

        PaymentGateway::create($validated);

        return redirect()->route('admin.payment-gateways.index')
            ->with('status', 'Payment gateway created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentGateway $paymentGateway)
    {
        return view('admin.payment_gateways.show', compact('paymentGateway'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentGateway $paymentGateway)
    {
        return view('admin.payment_gateways.edit', compact('paymentGateway'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentGateway $paymentGateway)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:bkash,nagad,rocket,bank',
            'account_number' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'status' => 'boolean',
        ]);

        $paymentGateway->update($validated);

        return redirect()->route('admin.payment-gateways.index')
            ->with('status', 'Payment gateway updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentGateway $paymentGateway)
    {
        $paymentGateway->delete();

        return redirect()->route('admin.payment-gateways.index')
            ->with('status', 'Payment gateway deleted successfully.');
    }
}
