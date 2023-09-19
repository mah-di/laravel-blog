<?php

namespace App\Http\Requests\Blog;

use App\Facades\SaveCoverImageFacade;
use App\Models\Blog;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BlogCreateRequest extends FormRequest
{
    public $blog_id;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', File::image()->min('128kb')->max('5120kb')]
        ];
    }

    protected function passedValidation()
    {
        if (!$this->session()->get('category')) {
            $this->session->flash('category_missing', true);
            return;
        }
        
        if (!$this->session()->get('sub_category')) {
            $this->session->flash('sub_category_missing', true);
            return;
        }

        $blog = [
            'title' => $this->title,
            'body' => $this->body,
            'user_id' => $this->user()->id,
            'category_id' => intval($this->session()->get('category')),
            'sub_category_id' => intval($this->session()->get('sub_category')),
        ];

        if ($this->cover_image !== null) {
            $blog['cover_image'] = SaveCoverImageFacade::save($this->file('cover_image'));
        }

        $blog_id = Blog::create($blog)->id;

        $this->session()->flash('blog_id', $blog_id);
    }

    protected function failedValidation(Validator $validator)
    {
        $this->session()->reflash();

        throw new ValidationException($validator);
    }

}
