<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;






class OAuthController extends Controller
{
    public function githubRedirect(Request $request): RedirectResponse
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback(Request $request): RedirectResponse
    {
        $user = Socialite::driver('github')->user();

        $this->authenticateUser($user);
        
        return Redirect::route('dashboard');
    }
    
    public function googleRedirect(Request $request): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }
    
    public function googleCallback(Request $request): RedirectResponse
    {
        $user = Socialite::driver('google')->user();

        $this->authenticateUser($user);
        
        return Redirect::route('dashboard');
    }
    
    protected function authenticateUser($user): void
    {
        $user = User::firstOrCreate(['email' => $user->email], ['name' => $user->name, 'profile_image' => $user->avatar, 'password' => Str::uuid()->toString()]);
    
        Auth::login($user);
    }
}
