<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactNumberUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ContactNumberController extends Controller
{
    function update(ContactNumberUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        
        $request->user()->save();
        
        return Redirect::back()->with('status', 'contact-updated');
    }
    
    function delete(Request $request): RedirectResponse
    {
        $request->user()->update(['contact_number' => null]);

        $request->user();

        return Redirect::back()->with('status', 'contact-deleted');
    }
}
