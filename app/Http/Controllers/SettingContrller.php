<?php

namespace App\Http\Controllers;

use App\Models\CurlOption;
use Illuminate\Http\Request;

class SettingContrller extends Controller
{
    public function index()
    {
        $settings = CurlOption::get();

        return view('admin.settings.index', compact('settings',));
    }

    public function create()
    {

        return view('admin.settings.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        $setting = CurlOption::findOrFail($id);
        return view('admin.settings.show', compact('setting'));
    }

    public function edit(string $id)
    {
        $setting = CurlOption::findOrFail($id);
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        $setting = CurlOption::findOrFail($id);
        $setting->delete();

        return redirect()->back()->with('success', 'Настройка удалена');
    }
}
