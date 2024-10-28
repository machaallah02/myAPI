<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'createdAt' => $this->created_at,
            'posts' => PostResource::collection($this->whenLoaded('posts')),
            'updatedAt' => $this->updated_at,
            'postsCount' => $this->whenCounted('posts'),
        ];
    }
}
