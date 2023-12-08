<?php

namespace App\Http\Controllers;

use App\Models\Path;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        $pathCount = Path::count();

        return view('admin.statistic.index', compact('pathCount'));
    }
}
