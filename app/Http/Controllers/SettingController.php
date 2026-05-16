<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        if (!$setting) {
            $setting = Setting::create([
                'company_name' => 'My Inventory Company',
                'currency' => 'BDT',
                'timezone' => 'Asia/Dhaka',
                'low_stock_limit' => 5,
            ]);
        }

        return view('settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_email' => ['nullable', 'email', 'max:255'],
            'company_phone' => ['nullable', 'string', 'max:50'],
            'company_address' => ['nullable', 'string'],
            'currency' => ['required', 'string', 'max:20'],
            'timezone' => ['required', 'string', 'max:100'],
            'low_stock_limit' => ['required', 'integer', 'min:0'],
        ]);

        $setting = Setting::first();

        if (!$setting) {
            Setting::create($validated);
        } else {
            $setting->update($validated);
        }

        return redirect()
            ->route('settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
