<?php

namespace App\Http\Requests\Blog;

use DateTime;
use App\Models\Blog;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;

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
        $blog = [
            'title' => $this->title,
            'body' => $this->body,
            'user_id' => $this->user()->id
        ];

        if ($this->cover_image !== null) {
            $dt = DateTime::createFromFormat('U.u', microtime(true));
            $now = $dt->format("YmdHisu");

            $extention = $this->file('cover_image')->getClientOriginalExtension();
            $filename = Str::uuid()->toString()."$now.$extention";

            $image = Image::make($this->file('cover_image'));
            $image->fit(1152, 300);

            $path = "img/cover-images/$filename";

            Storage::disk('public')->put($path, $image->encode());
            $blog['cover_image'] = $path;
        }

        $this->blog_id = Blog::create($blog)->id;
    }
}
