<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'credential' => ['required', 'string'], // 'credential' bisa berupa email, NIM, NIP, atau username
            'password' => ['required', 'string'],
            'captcha' => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Data tidak boleh kosong',
            'credential.required' => 'Email/NIM/NIP/Username tidak boleh kosong',
            'captcha.required' => 'Captcha tidak boleh kosong',
            'captcha.string' => 'Input Captcha harus berupa string',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credentials = $this->only('credential', 'password');

        // Pertama, coba otentikasi menggunakan email atau username
        if (Auth::attempt(['email' => $credentials['credential'], 'password' => $credentials['password']]) ||
            Auth::attempt(['username' => $credentials['credential'], 'password' => $credentials['password']])) {
            return; // Berhasil login
        }

        // Jika tidak berhasil, coba cari user berdasarkan NIM atau NIP
        $user = User::whereHas('asesi', function ($query) use ($credentials) {
                        $query->where('nim', $credentials['credential']);
                    })
                    ->orWhereHas('asesor', function ($query) use ($credentials) {
                        $query->where('nip', $credentials['credential']);
                    })
                    ->first();

        // Jika user ditemukan dan password cocok, login menggunakan user id
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::loginUsingId($user->id);
            return;
        }

        // Jika semua upaya otentikasi gagal
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'credential' => trans('auth.failed'),
        ]);
    }


    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'credential' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('credential')).'|'.$this->ip());
    }
}