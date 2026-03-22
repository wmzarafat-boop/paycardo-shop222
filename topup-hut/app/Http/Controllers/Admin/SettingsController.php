<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('backend.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'currency' => 'required|string|max:10',
            'currency_symbol' => 'required|string|max:5',
        ]);

        $fields = [
            'site_name', 'site_tagline', 'logo', 'favicon',
            'currency', 'currency_symbol', 'phone', 'email',
            'address', 'facebook', 'youtube', 'twitter', 'instagram',
            'bkash_number', 'rocket_number', 'nagad_number',
        ];

        foreach ($fields as $field) {
            Setting::set($field, $request->$field ?? '');
        }

        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
