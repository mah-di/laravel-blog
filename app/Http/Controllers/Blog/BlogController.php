<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogCreateRequest;
use App\Http\Requests\Blog\BlogUpdateRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function show($blog_id): View
    {
        $blog = Blog::find($blog_id);

        $blogger = $blog->user;

        $relatedBlogs = Blog::fetchBlogs(5, ['user_id' => $blogger->id]);

        return view('blog.show', ['blog' => $blog, 'blogger' => $blogger, 'relatedBlogs' => $relatedBlogs]);
    }

    public function showStep1(Request $request): View
    {
        $categories = Category::all();

        return view('blog.create', ['user' => $request->user(), 'categories' => $categories, 'step' => 1]);
    }
    
    public function storeStep1(Request $request): RedirectResponse
    {
        if ($request->category == null) {
            return Redirect::back()->with('error', 'You must provide a category');
        }

        [$category, $category_name] = explode('|', $request->category);

        $request->session()->flash('category', $category);
        $request->session()->flash('category_name', $category_name);

        if (!Category::find($category)) {
            return Redirect::back()->with('error', 'Please select a valid category');
        }

        return Redirect::route('blog.show.step2');
    }

    public function showStep2(Request $request): View | RedirectResponse
    {
        if (!$request->session()->get('category')) {
            return Redirect::route('blog.show.step1');
        }

        $request->session()->reflash();

        $category = $request->session()->get('category');
        $category_name = $request->session()->get('category_name');

        $sub_categories = SubCategory::where(['category_id' => $category])->get();

        return view('blog.create', ['user' => $request->user(), 'category' => $category, 'category_name' => $category_name, 'sub_categories' => $sub_categories, 'step' => 2]);
    }
    
    public function storeStep2(Request $request): RedirectResponse
    {
        $request->session()->keep(['category', 'category_name']);

        if ($request->sub_category) {
            [$sub_category, $sub_category_name] = explode('|', $request->sub_category);
        } else {
            [$sub_category, $sub_category_name] = [null, null];
        }
        
        if ($request->sub_category && !SubCategory::where(['id' => $request->sub_category, 'category_id' => $request->category])->count()) {
            return Redirect::back()->with('error', 'Please select a valid sub category');
        }

        $request->session()->flash('sub_category', $sub_category);
        $request->session()->flash('sub_category_name', $sub_category_name);

        return Redirect::route('blog.show.step3');
    }    
    
    public function showStep3(Request $request): View | RedirectResponse
    {
        if (!$request->session()->get('category')) {
            return Redirect::route('blog.show.step1');
        }

        if (!$request->session()->get('sub_category')) {
            $request->session()->keep(['category', 'category_name']);
            return Redirect::route('blog.show.step2');
        }
    
        $request->session()->reflash();

        $category = $request->session()->get('category');
        $category_name = $request->session()->get('category_name');

        $sub_category = $request->session()->get('sub_category');
        $sub_category_name = $request->session()->get('sub_category_name');

        return view('blog.create', ['user' => $request->user(), 'category' => $category, 'sub_category' => $sub_category, 'category_name' => $category_name, 'sub_category_name' => $sub_category_name, 'step' => 3]);
    }

    public function storeStep3(BlogCreateRequest $request): RedirectResponse
    {
        if ($request->session()->get('category_missing')) {
            return Redirect::route('blog.show.step1');
        }

        if ($request->session()->get('sub_category_missing')) {
            return Redirect::route('blog.show.step2');
        }

        return Redirect::route('blog.show', $request->session()->get('blog_id'));
    }

    public function update(BlogUpdateRequest $request)
    {

    }

    public function delete(Request $request)
    {

    }

}
