<?php

namespace App\Http\Controllers;

use App\Models\Asesi;
use Illuminate\Http\Request;
use App\Models\KelompokAsesor;
use Illuminate\Support\Facades\{Auth,Gate};

class FRAPLcontroller extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $uuid = request()->query->keys()[0];
        $query = KelompokAsesor::with(['skema','event','kelas','asesor.user','frapl01','frapl02']);

        if(Gate::allows('asesor')  || Gate::allows('admin')) {
            $asesi = Asesi::firstWhere('uuid',$uuid);
            $kelompokAsesorId = request('kelompok-asesor-id');
            $asesiId = $asesi['id'];
            $asesiName = $asesi->user['name'];
            $asesiPhoto = $asesi->user['photo'];
            $asesiRole = $asesi->user['role'];
            $kelompokAsesorNotIn = (clone $query)->where('uuid','!=',$kelompokAsesorId)->get();
            $kelompokAsesor = $query->where([
                ['kelas_id',$asesi['kelas_id']],
                ['uuid', $kelompokAsesorId]
            ])->first();
        } elseif (Gate::allows('asesi')) {
            $asesiId = Auth::user()->asesi['id'];
            $asesiName = Auth::user()->name;
            $asesiPhoto = Auth::user()->photo;
            $asesiRole = Auth::user()->role;
            $kelompokAsesorNotIn = (clone $query)->where('uuid','!=',$uuid)->get();
            $kelompokAsesor = $query->firstWhere('uuid',$uuid);
        }
        return view('dashboard.frapl.index',compact('kelompokAsesor','kelompokAsesorNotIn','asesiId','asesiName','asesiPhoto','asesiRole'));
    }
}
