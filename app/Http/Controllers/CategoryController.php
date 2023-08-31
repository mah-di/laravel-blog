<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryCreateUpdateRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function store(CategoryCreateUpdateRequest $request): RedirectResponse
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

    public function update(CategoryCreateUpdateRequest $request, int $id): RedirectResponse
    {
        return Redirect::route('admin.dashboard');
    }

    public function delete(Request $request, int $id): RedirectResponse
    {
        return Redirect::back();
    }

}
