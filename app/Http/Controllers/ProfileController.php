<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{

    $latestPhoto = Auth::user()->photo;

    $request->user()->fill($request->validated());

    $photo = $request->file('photo');

    if ($photo && !empty($photo)) {
        if (!is_null($latestPhoto) && Storage::disk('public')->exists($latestPhoto)) {
            Storage::disk('public')->delete($latestPhoto);
        }

        $path = $photo->store('profilePicture', 'public');

        $request->user()->photo = $path;
    }

    if ($request->user()->isDirty('email')) {
        $request->user()->email_verified_at = null;
    }

    
    $request->user()->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}

}
