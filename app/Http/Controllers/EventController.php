<?php

namespace App\Http\Controllers;

use App\Models\{Event,Skema};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.event.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_event' => ['required', 'string', 'max:255', 'unique:m_event,nama_event'],
            'tuk' => ['required','in:Sewaktu,Tempat Kerja,Mandiri'],
            'event_mulai' => ['required','date'],
            'event_selesai' => ['required','date'],
            'keterangan' => ['required', 'string', 'max:255']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        $data =  Event::create($validated);
        if ($data) {
            return response()->json(['status' => 'success', 'message' => 'Data event berhasil ditambahkan'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        $event = Event::firstWhere('uuid', $uuid);
        if($event) {
            return response()->json(['status' => 'success', 'data' => $event], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data event tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'nama_event' => ['required', 'string', 'max:255', 'unique:m_event,nama_event,'. $uuid . ',uuid'],
            'tuk' => ['required','in:Sewaktu,Tempat Kerja,Mandiri'],
            'event_mulai' => ['required','date'],
            'event_selesai' => ['required','date'],
            'keterangan' => ['required', 'string', 'max:255']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        $data = Event::where('uuid', $uuid)->first();
        if(empty($data)) {
            return response()->json(['status' => 'error', 'message' => 'Data event tidak ditemukan'], 404);
        }
        $result =  $data->update($validated);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data event berhasil diubah'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $event = Event::where('uuid', $uuid);
        if(empty($event->first())) {
            return response()->json(['status' => 'error', 'message' => 'Data event tidak ditemukan'], 404);
        }
        if($event->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Data event berhasil dihapus'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data event gagal dihapus'], 500);
        }

    }

    public function datatable()
    {
        $data = Event::latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = Event::latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
