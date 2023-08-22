<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileImageUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProfileImageController extends Controller
{
    function update(ProfileImageUpdateRequest $request): RedirectResponse
    {
        return Redirect::back()->with('status', 'profile-image-updated');
    }
    
    public function delete(Request $request): RedirectResponse
    {
        $defaultProfileImage = env('DEFAULT_PROFILE_IMAGE');
    
        if ($request->user()->profile_image != $defaultProfileImage and Storage::disk('public')->exists($request->user()->profile_image)) {
            Storage::disk('public')->delete($request->user()->profile_image);
        }
    
        $request->user()->update(['profile_image' => "$defaultProfileImage"]);

        return Redirect::back()->with('status', 'profile-image-deleted');
    }
}
