<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Skema;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        $skema = Skema::latest()->limit(3)->get();
        return view('guest.index',compact('skema'));
    }

    public function registerAssesmen()
    {
        $jurusan = Jurusan::latest()->get();
        return view('guest.registerAssesmen.index',compact('jurusan'));
    }
}
