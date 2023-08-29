<?php

namespace App\Http\Controllers;

use App\Facades\ImageCleanupFacade;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            abort(404);
        }

        $blogs = Blog::fetchBlogs(4, ['user_id' => $user->id]);
        $blogCount = Blog::where(['user_id' => $user->id])->count();

        return view('profile.show', ['user' => $user, 'blogs' => $blogs, 'blogCount' => $blogCount]);
    }

    /**
     * Display the user's profile form.
     */
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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        ImageCleanupFacade::run($user->profile_image);

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
