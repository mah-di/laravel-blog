<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends CategoryCreateRequest
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
            'category' => ['required', 'string', 'regex:/^[A-Za-z0-9-+.#()\/ ]+$/', Rule::unique(Category::class, 'name')->ignore($this->id)],
        ];
    }

    public function passedValidation(): void
    {
        $category = ucwords(trim($this->category), " \t\r\n\f\v/");
        $category = Category::find($this->id)->update(['name' => $category]);
    }

}
