<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FreeClassLead;
use Illuminate\Http\Request;

class FreeClassLeadController extends Controller
{
    public function index(Request $request)
    {
        $query = FreeClassLead::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $leads = $query->paginate(20)->withQueryString();

        return view('admin.free_class_leads.index', compact('leads'));
    }

    public function updateStatus(Request $request, FreeClassLead $lead)
    {
        $request->validate(['status' => 'required|in:new,contacted,enrolled,archived']);
        $lead->update(['status' => $request->status]);

        return back()->with('success', 'Status updated.');
    }

    public function updateNotes(Request $request, FreeClassLead $lead)
    {
        $request->validate(['notes' => 'nullable|string|max:1000']);
        $lead->update(['notes' => $request->notes]);

        return back()->with('success', 'Notes saved.');
    }

    public function destroy(FreeClassLead $lead)
    {
        $lead->delete();
        return back()->with('success', 'Lead deleted.');
    }
}
