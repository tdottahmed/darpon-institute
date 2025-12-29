<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Show the settings form.
     */
    public function index()
    {
        $settings = [
            // Steadfast API
            'steadfast_api_key' => Setting::get('steadfast_api_key'),
            'steadfast_secret_key' => Setting::get('steadfast_secret_key'),
            
            // Fraud Check Credentials - Pathao
            'pathao_user' => Setting::get('pathao_user'),
            'pathao_password' => Setting::get('pathao_password'),
            
            // Fraud Check Credentials - Steadfast
            'steadfast_user' => Setting::get('steadfast_user'),
            'steadfast_password' => Setting::get('steadfast_password'),
            
            // Fraud Check Credentials - Redex
            'redx_phone' => Setting::get('redx_phone'),
            'redx_password' => Setting::get('redx_password'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            // Steadfast API
            'steadfast_api_key' => 'nullable|string',
            'steadfast_secret_key' => 'nullable|string',
            
            // Fraud Check Credentials - Pathao
            'pathao_user' => 'nullable|string|email',
            'pathao_password' => 'nullable|string',
            
            // Fraud Check Credentials - Steadfast
            'steadfast_user' => 'nullable|string|email',
            'steadfast_password' => 'nullable|string',
            
            // Fraud Check Credentials - Redex
            'redx_phone' => 'nullable|string',
            'redx_password' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings.index')
            ->with('status', 'Settings updated successfully.');
    }
}
