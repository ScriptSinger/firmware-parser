<?php

namespace App\Http\Controllers;

use App\Models\Firmware;
use App\Models\Path;
use Illuminate\Http\Request;

class FirmwareController extends Controller
{
    public function index()
    {
        $firmwares = Firmware::paginate(50);
        return view('admin.firmwares.index', compact('firmwares',));
    }

    public function show(string $id)
    {
        $firmware = Firmware::findOrFail($id);
        return view('admin.firmwares.show', compact('firmware'));
    }

    public function downloadFile($filename)
    {
        $path = storage_path('app/public/firmwares/' . $filename);
        return response()->download($path);
    }
}
