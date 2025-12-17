<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $penaltyPerDay = Setting::where('key', 'penalty_per_day')->value('value') ?? 20000;
        return view('admin.settings.index', compact('penaltyPerDay'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'penalty_per_day' => 'required|numeric|min:0'
        ]);

        Setting::updateOrCreate(
            ['key' => 'penalty_per_day'],
            ['value' => $request->penalty_per_day]
        );

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui');
    }
}
