<?php

namespace App\Http\Controllers;

use App\Models\Asesi;
use App\Models\Event;
use App\Models\Skema;
use App\Models\Asesor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAsesor = Asesor::count(); 
        $totalAsesi = Asesi::count();
        $totalSkema = Skema::count();
        $totalEvent = Event::count();

        return view('dashboard.index', compact('totalAsesor', 'totalAsesi', 'totalSkema', 'totalEvent'));
    }
}
