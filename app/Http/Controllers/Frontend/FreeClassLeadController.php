<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FreeClassLead;
use App\Services\MetaConversionsApi;
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

        $lead = FreeClassLead::create([
            ...$validated,
            'ip_address' => $request->ip(),
        ]);

        // The browser pixel uses the same "lead-{id}" event ID for deduplication
        MetaConversionsApi::track('Lead', 'lead-' . $lead->id, $validated, ['content_name' => 'Free Class'], $request);

        return response()->json(['message' => 'Registration successful.', 'lead_id' => $lead->id], 201);
    }
}
