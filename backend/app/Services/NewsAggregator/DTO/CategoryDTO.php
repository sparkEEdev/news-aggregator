<?php

namespace App\Services\NewsAggregator\DTO;

class CategoryDTO
{
    public function __construct(
        private string $slug,
        private string $name,
    ) {
    }

    static function fromNewsOrgData(array $data): CategoryDTO
    {
        return new CategoryDTO(
            slug: $data['id'] ?? '',
            name: $data['name'] ?? '',
        );
    }

    public function toModel(): array
    {
        return [
            'slug' => $this->slug,
            'name' => $this->name,
        ];
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function name(): string
    {
        return $this->name;
    }
}
