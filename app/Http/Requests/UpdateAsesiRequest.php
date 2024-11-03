<?php

namespace App\Http\Requests;

use App\Models\{User,Asesi};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAsesiRequest extends FormRequest
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
        $asesiUuid = $this->input('asesi_uuid');
        $asesiData = Asesi::firstWhere('uuid',$asesiUuid);
        return [
            'nim' => ['required','numeric',Rule::unique(Asesi::class)->ignore($asesiData['id'])],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($asesiData['user_id'])],
            'name' => ['required','min:3','string'],
            'kelas_id' => ['required', 'exists:m_kelas,uuid'],
            'phone'=>['nullable','regex:/(08)[0-9]{9}/', Rule::unique(User::class,'phone')->ignore($asesiData['user_id'])],
            'username' => ['required','string', Rule::unique(User::class,'username')->ignore($asesiData['user_id'])],
            'photo' => [
                'nullable',
                File::types(['jpg', 'jpeg','png'])
                    ->min('1kb')
                    ->max('2mb'),
                ],
            'jenis_kelamin' => ['nullable','in:Laki-laki,Perempuan'],
            'address' => ['nullable','string'],
            'status' => ['nullable','in:active,nonactive'],
            'status_assesmen' => ['nullable','in:active,nonactive']
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
            'regex' => 'Format tidak sesuai'
        );
    }
}
