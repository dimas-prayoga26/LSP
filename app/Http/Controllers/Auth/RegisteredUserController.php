<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Asesi;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Mews\Captcha\Facades\Captcha;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'phone' => ['required','regex:/(08)[0-9]{9}/'],
            'nim' => ['required','numeric'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],$this->messageValidation());
        DB::beginTransaction();
        if (Captcha::check($request->captcha)) {
            $existingEmail = User::where('email',$request->email)->exists();
            $existingPhone = User::where('phone',$request->phone)->exists();
            $existingNim = Asesi::where('nim',$request->nim)->exists();

            if($existingNim) {
                DB::rollBack();
                return back()->with('error','NIM/NPM telah terdaftar, silahkan coba lagi!');
            }
            if($existingEmail) {
                DB::rollBack();
                return back()->with('error','Email telah terdaftar, silahkan coba lagi!');
            }
            if($existingPhone) {
                DB::rollBack();
                return back()->with('error','No Telepon telah terdaftar, silahkan coba lagi!');
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            $asesi = Asesi::create([
                'user_id' => $user['id'],
                'nim' => $request->nim,
                'kelas_id' => $request->kelas_id
            ]);

            if(!$user || !$asesi) {
                DB::rollBack();
                return back()->with('error','Terjadi kesalahan dalam mendaftar, silahkan coba lagi!');
            }
        } else {
            DB::rollBack();
            return back()->with('failed-captcha','Kode Captcha tidak sesuai');
        }
        // event(new Registered($user));
        // Auth::login($user);
        DB::commit();
        return back()->with('success','Selamat, Kamu berhasil mendaftar. Selanjutnya akunmu akan ditinjau oleh Admin Maks. 3x24 Jam untuk dilakukan verifikasi.');
    }
}
