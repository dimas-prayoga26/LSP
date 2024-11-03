<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function messageValidation()
    {
        return array(
            'required' => 'Data tidak boleh kosong',
            'max' => 'Maksimal berjumlah :max karakter',
            'min' => 'Minimal berjumlah :min karakter',
            'string' => 'Format harus berupa string',
            'unique' => 'Data tidak boleh sama',
            'email' => 'Masukkan format email yang benar',
            'numeric' => 'Format harus berupa angka',
            'in' => 'Data harus salah satu dari :values',
            'date' => 'Data harus berupa tanggal',
            'integer' => 'Data harus berupa angka',
            'mimes' => 'Format yang diperbolehkan :values'
        );
    }
}
