<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rule;
use App\Models\{User,Asesor};
class UpdateAsesorRequest extends FormRequest
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
        $asesorUuid = $this->input('asesor_uuid');
        $asesorData = Asesor::firstWhere('uuid', $asesorUuid);

        return [
            'nip' => ['required','numeric', Rule::unique(Asesor::class,'nip')->ignore($asesorData['id'])],
            'email' => ['required', 'lowercase','email', 'min:3', 'max:50', Rule::unique(User::class)->ignore($asesorData['user_id'])],
            'name' => ['required','min:3','string'],
            'phone'=>['nullable','regex:/(08)[0-9]{9}/', Rule::unique(User::class)->ignore($asesorData['user_id'])],
            'username' => ['required','string', Rule::unique(User::class)->ignore($asesorData['user_id'])],
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
            'address' => ['nullable','string'],
            'status' => ['nullable','in:active,nonactive']
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
