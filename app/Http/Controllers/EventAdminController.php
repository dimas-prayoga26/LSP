<?php

namespace App\Http\Controllers;

use App\Models\{Asesi,KelompokAsesor};
use Illuminate\Http\Request;

class EventAdminController extends Controller
{

    public function index()
    {
        return view('dashboard.eventAdmin.index');
    }

    /**
     * Handle the incoming request.
     */
    public function datatable($uuid)
    {
        $asesi = Asesi::firstWhere('uuid',$uuid);
        $data = KelompokAsesor::with(['skema','event','kelas','asesor.user'])
        ->where('kelas_id', $asesi['kelas_id'])
        ->latest()
        ->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
