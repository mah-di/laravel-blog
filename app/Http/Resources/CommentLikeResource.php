<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentLikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    =>      $this->id,
            'date_created'          =>      $this->date_created,

            'user'                  =>  [
                'id'                =>      $this->user_id,
                'name'              =>      $this->user->name,
                'avatar'            =>      $this->user->profile_image_url,
                'url'               =>      $this->user->url,
            ],

            'comment'               =>  [
                'id'                =>      $this->likable_id,
                'body_preview'      =>      $this->likable->body_preview,
                'url'               =>      $this->likable->url,
            ],
        ];
    }
}
