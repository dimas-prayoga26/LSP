<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
class StoreAsesorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nip' => ['required','min:8','numeric', Rule::unique('m_asesor')],
            'email' => ['required', 'lowercase','email', 'min:3', 'max:50', Rule::unique('users')],
            'name' => ['required','min:3','string'],
            'phone'=>['nullable','regex:/(08)[0-9]{9}/',Rule::unique('users')],
            'photo' => [
                'nullable',
                File::types(['jpg', 'jpeg','png'])
                    ->min('1kb')
                    ->max('2mb'),
                ],
            'surat_tugas' => [
                'nullable',
                File::types(['pdf'])
                    ->min('1kb')
                    ->max('5mb'),
                ],
            'jenis_kelamin' => ['nullable','in:Laki-laki,Perempuan'],
            'address' => ['nullable','string']
        ];
    }

    public function messages()
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
            'mimes' => 'Format file harus :values',
            'photo.max' => 'Ukuran file maksimal 2 MB',
            'surat_tugas.max' =>'Ukuran file maksimal 5 MB',
            'regex' => 'Format tidak sesuai'
        );
    }
}
