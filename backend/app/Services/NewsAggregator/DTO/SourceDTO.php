<?php

namespace App\Services\NewsAggregator\DTO;

class SourceDTO
{
    public function __construct(
        private string $slug,
        private string $name,
        private string $description,
        private string $url,
        private string $category,
    ) {
    }

    static function fromArray(array $data): SourceDTO
    {
        return new SourceDTO(
            slug: $data['id'] ?? '',
            name: $data['name'] ?? '',
            description: $data['description'] ?? '',
            url: $data['url'] ?? '',
            category: $data['category'] ?? '',
        );
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function category(): string
    {
        return $this->category;
    }
}
