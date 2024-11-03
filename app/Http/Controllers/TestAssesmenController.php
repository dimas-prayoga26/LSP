<?php

namespace App\Http\Controllers;

use App\Models\{Asesi,TestTulis,TestPraktek,KelompokAsesor};
use Illuminate\Support\Facades\{Gate,Auth};

class TestAssesmenController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $uuid = request()->query->keys()[0];
        $query = KelompokAsesor::with(['skema.unitKompetensi.testTulis','event','kelas','asesor.user','userTestTulis','userTestPraktek','userTestWawancara']);

        if(Gate::allows('asesor') || Gate::allows('admin')) {
            $asesi = Asesi::firstWhere('uuid',$uuid);
            $kelompokAsesorId = request('kelompok-asesor-id');
            $asesiId = $asesi['id'];
            $asesiName = $asesi->user['name'];
            $asesiPhoto = $asesi->user['photo'];
            $kelompokAsesorNotIn = (clone $query)->where('uuid','!=',$kelompokAsesorId)->get();
            $kelompokAsesor = $query->firstWhere([
                ['kelas_id',$asesi['kelas_id']],
                ['uuid', $kelompokAsesorId]
            ]);
        } elseif (Gate::allows('asesi')) {
            $asesiId = Auth::user()->asesi['id'];
            $asesiName = Auth::user()->name;
            $asesiPhoto = Auth::user()->photo;
            $kelompokAsesorNotIn = (clone $query)->where('uuid','!=',$uuid)->get();
            $kelompokAsesor = $query->firstWhere('uuid',$uuid);
        }
        $testTulisCount = TestTulis::whereIn('unit_kompetensi_id',$kelompokAsesor->skema->unitKompetensi->pluck('id'))->count();
        $testPraktikCount = TestPraktek::where('skema_id', $kelompokAsesor->skema['id'])->count();

        return view('dashboard.testAssesmen.index',compact('kelompokAsesor','kelompokAsesorNotIn','testTulisCount','testPraktikCount','asesiId','asesiName','asesiPhoto'));
    }
}
