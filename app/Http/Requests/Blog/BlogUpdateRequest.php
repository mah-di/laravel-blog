<?php

namespace App\Http\Requests\Blog;

use App\Facades\ImageCleanupFacade;
use App\Facades\SaveCoverImageFacade;
use App\Models\Blog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class BlogUpdateRequest extends FormRequest
{
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

    public function passedValidation(): void
    {
        $updatedBlog = [
            'title' => $this->title,
            'body' => $this->body,
            'category_id' => $this->category,
            'sub_category_id' => $this->subCategory,
        ];

        if ($this->cover_image !== null) {
            $path = Blog::find($this->id)->cover_image;

            ImageCleanupFacade::coverImageCleanup($path);

            $path = SaveCoverImageFacade::save($this->file('cover_image'));

            $updatedBlog['cover_image'] = $path;
        }

        Blog::find($this->id)->update($updatedBlog);
    }
}
