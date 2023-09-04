<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\SubCategoryCreateRequest;
use App\Models\SubCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SubCategoryController extends Controller
{

    public function delete(Request $request, int $id): RedirectResponse
    {
        SubCategory::find($id)->delete();

        return Redirect::back();
    }
    
    public function create(SubCategoryCreateRequest $request): RedirectResponse
    {
        return Redirect::back();
    }

}
