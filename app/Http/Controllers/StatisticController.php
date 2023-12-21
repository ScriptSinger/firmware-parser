<?php

namespace App\Http\Controllers;

use App\Models\Firmware;
use App\Models\Path;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        $pathCount = Path::count();
        $firmwaresCount = Firmware::count();

        return view('admin.statistic.index', compact('pathCount', 'firmwaresCount'));
    }
}
