<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @mixin \App\Models\Post
 * @mixin \App\Models\Category
 */

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "title" => $this->title,
            "body" => $this->body,
            "author" => $this->author,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "category" => $this->category->name,
        ];
    }
}
