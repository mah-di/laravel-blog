<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class CommentCreateRequest extends FormRequest
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
            'body' => ['required', 'string'],
        ];
    }

    public function passedValidation()
    {
        $comment = [
            'body' => $this->body,
            'user_id' => $this->user()->id,
            'blog_id' => $this->blog_id,
            'parent_id' => $this->parent_id,
        ];

        Comment::create($comment);
    }

}
