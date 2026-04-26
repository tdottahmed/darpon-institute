<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FreeClassLead;
use Illuminate\Http\Request;

class FreeClassLeadController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        FreeClassLead::create([
            ...$validated,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['message' => 'Registration successful.'], 201);
    }
}
