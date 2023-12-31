<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryCreateRequest extends FormRequest
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
            'category' => ['required', 'string', 'regex:/^[A-Za-z0-9-+.#()\/ ]+$/', Rule::unique(Category::class, 'name')],
            'sub_categories' => ['nullable', 'regex:/^[A-Za-z0-9-+.#,()\/ ]+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'category.regex' => 'Invalid special characters submitted. Allowed special characters for Categories are ".", "#", "+", "-", "()" and "/"',
            'sub_categories.regex' => 'Invalid special characters submitted. Allowed special characters for Sub Categories are ".", "#", "+", "-", "()" and "/"',
        ];
    }

    public function passedValidation(): void
    {
        $category = ucwords(trim($this->category), " \t\r\n\f\v/");
        $category = Category::create(['name' => $category]);

        $sub_categories = $this->getSubCategories();

        foreach ($sub_categories as $sub_category) {
            SubCategory::create(['name' => $sub_category, 'category_id' => $category->id]);
        }

    }

    protected function getSubCategories(): array
    {
        $sub_categories = explode(',', $this->sub_categories);
        $sub_categories = array_map(fn($val) => ucwords(trim($val), " \t\r\n\f\v/"), $sub_categories);
        $sub_categories = array_unique($sub_categories);
        
        return array_filter($sub_categories, fn($val) => $val !== "");
    }

}
