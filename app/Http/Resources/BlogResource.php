<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                =>      $this->id,
            'user_id'           =>      $this->user_id,
            'user_name'         =>      $this->user->name,
            'user_avatar'       =>      $this->user->profile_image_url,
            'cover_image'       =>      $this->cover_image_url,
            'title'             =>      $this->title_upper,
            'body'              =>      $this->body_preview,
            'category_id'       =>      $this->category_id,
            'category'          =>      $this->category->name,
            'sub_category_id'   =>      $this->sub_category_id,
            'sub_category'      =>      $this->sub_category->name,
            'date_created'      =>      $this->date_created,
        ];
    }
}
