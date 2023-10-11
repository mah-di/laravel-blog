<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\SubCategoryCreateRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\SubCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
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

    public function showBlogs(Request $request, int $id): View
    {
        $subCategory = SubCategory::find($id);

        return view('subCategory.show', ['subCategory' => $subCategory]);
    }

    public function fetchBlogs(int $id, int $pageSize = 5): ResourceCollection
    {
        $blogs = Blog::latest()->where(['sub_category_id' => $id])->paginate($pageSize);

        return BlogResource::collection($blogs);
    }

}
