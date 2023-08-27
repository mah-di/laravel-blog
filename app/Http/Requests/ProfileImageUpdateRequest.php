<?php

namespace App\Http\Requests;

use App\Facades\ImageCleanupFacade;
use DateTime;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rules\File;

class ProfileImageUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'profile_image' => ['required', File::image()->min('32kb')->max('2048kb')]
        ];
    }

    protected function passedValidation()
    {
        $dt = DateTime::createFromFormat('U.u', microtime(true));
        $now = $dt->format("YmdHisu");

        $extention = $this->file('profile_image')->getClientOriginalExtension();
        $filename = Str::uuid()->toString()."$now.$extention";

        $image = Image::make($this->file('profile_image'));
        $image->fit(512, 512);

        $path = "img/profile-images/$filename";

        Storage::disk('public')->put($path, $image->encode());

        ImageCleanupFacade::run($this->user()->profile_image);

        $this->user()->update(['profile_image' => "$path"]);
    }
}
