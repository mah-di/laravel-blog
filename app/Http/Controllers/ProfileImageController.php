<?php

namespace App\Http\Controllers;

use App\Facades\ImageCleanupFacade;
use App\Http\Requests\ProfileImageUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProfileImageController extends Controller
{
    function update(ProfileImageUpdateRequest $request): RedirectResponse
    {
        return Redirect::back()->with('status', 'profile-image-updated');
    }
    
    public function delete(Request $request): RedirectResponse
    {
        $defaultProfileImage = ImageCleanupFacade::run($request->user()->profile_image);
    
        $request->user()->update(['profile_image' => "$defaultProfileImage"]);

        return Redirect::back()->with('status', 'profile-image-deleted');
    }
}
