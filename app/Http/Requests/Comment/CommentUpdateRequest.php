<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class CommentUpdateRequest extends FormRequest
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

    public function messages(): array
    {
        return [
            'body.required' => "Comment can't be blank",
        ];
    }

    public function passedValidation(): void
    {
        Comment::find($this->id)->update(['body' => $this->body]);
    }

}
