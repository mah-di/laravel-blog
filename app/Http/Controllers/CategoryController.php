<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryCreateRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{

    public function show(): View
    {
        $categories = Category::all();

        return view('admin.category.show-categories', ['categories' => $categories]);
    }

    public function create(Request $request): View
    {
        return view('admin.category.create');
    }

    public function store(CategoryCreateRequest $request): RedirectResponse
    {
        return Redirect::route('admin.dashboard');
    }

    public function edit(Request $request, int $id): View
    {
        $category = Category::find($id);

        $sub_categories = $category->sub_categories;
        $sub_categories_input = '';

        foreach ($sub_categories as $sub_category) {
            $sub_categories_input .= "$sub_category->name, ";
        }

        return view('admin.category.edit', ['category' => $category, 'sub_categories_input' => $sub_categories_input]);
    }

    public function update(CategoryUpdateRequest $request, int $id): RedirectResponse
    {
        return Redirect::route('category.show');
    }

    public function delete(Request $request, int $id): RedirectResponse
    {
        Category::find($id)->delete();

        return Redirect::back();
    }

    public function showBlogs(Request $request, int $id): View
    {
        $category = Category::find($id);

        return view('category.show', ['category' => $category]);
    }

    public function fetchBlogs(int $id, int $pageSize = 5): ResourceCollection
    {
        $blogs = Blog::latest()->where(['category_id' => $id])->paginate($pageSize);

        return BlogResource::collection($blogs);
    }

}
