<?php

namespace App\Core\v1\Article\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'author' => $this->author,
            'url' => $this->url,
            'published_at' => $this->published_at,
            'sources' => ArticleSourceResource::collection($this->whenLoaded('sources')),
            'categories' => ArticleCategoryResource::collection($this->whenLoaded('categories')),
        ];
    }
}
