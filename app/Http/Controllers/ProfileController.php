<?php

namespace App\Http\Controllers;

use App\Facades\ImageCleanupFacade;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\BlogLikeResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\CommentLikeResource;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
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

        return view('profile.show', ['user' => $user]);
    }

    public function showDashboard(Request $request): View
    {
        $user = $request->user();

        return view('profile.dashboard', ['user' => $user]);
    }

    public function getLikedBlogs(Request $request, int $id)
    {}

    public function getLikedComments(Request $request, int $id)
    {}

    public function getBlogs(Request $request, int $user_id): ResourceCollection
    {
        $pageSize = $request->pageSize ?? 5;

        $blogs = (Blog::latest()->where(['user_id' => $user_id])->paginate($pageSize));

        return BlogResource::collection($blogs);
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
