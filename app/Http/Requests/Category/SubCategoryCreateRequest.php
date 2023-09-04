<?php

namespace App\Http\Requests\Category;

use App\Models\SubCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubCategoryCreateRequest extends FormRequest
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
            'category_id' => ['required', 'int'],
            'sub_category' => ['required', 'regex:/^[A-Za-z0-9-+.#()\/ ]+$/', Rule::unique(SubCategory::class, 'name')->where('category_id', $this->category_id)],
        ];
    }

    public function messages(): array
    {
        return [
            'sub_category.regex' => 'Invalid special characters submitted. Allowed special characters for Sub Categories are ".", "#", "+", "-", "()" and "/"',
            'sub_category.unique' => 'The sub category already exists in this category',
        ];
    }

    public function passedValidation(): void
    {
        $name = ucwords(trim($this->sub_category), " \t\r\n\f\v/");
        SubCategory::create(['name' => $name, 'category_id' => $this->category_id]);
    }

}
