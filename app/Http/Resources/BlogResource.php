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
            'cover_image'       =>      $this->cover_image_url,
            'title'             =>      $this->title_upper,
            'body_preview'      =>      $this->body_preview,
            'url'               =>      $this->url,
            'date_created'      =>      $this->date_created,

            'user'              =>  [
                'id'            =>      $this->user_id,
                'name'          =>      $this->user->name,
                'avatar'        =>      $this->user->profile_image_url,
                'url'           =>      $this->user->url,
            ],

            'category'          =>  [
                'id'            =>      $this->category_id,
                'name'          =>      $this->category->name,
                'url'           =>      $this->category->url,
            ],
            
            'sub_category'      =>  [
                'id'            =>      $this->sub_category_id,
                'name'          =>      $this->sub_category->name,
                'url'           =>      $this->sub_category->url,
            ],
        ];
    }
}
