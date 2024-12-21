<?php

namespace App\Services\NewsAggregator\DTO;

use App\Services\NewsAggregator\DTO\SourceDTO;

class ArticleDTO
{
    public function __construct(
        private string $author,
        private string $title,
        private string $description,
        private string $content,
        private string $publishedAt,
        private SourceDTO $source,
    ) {
    }

    static function fromArray(array $data): ArticleDTO
    {
        return new ArticleDTO(
            author: $data['author'],
            title: $data['title'],
            description: $data['description'],
            content: $data['content'],
            publishedAt: $data['publishedAt'],
            source: SourceDTO::fromArray($data['source']),
        );
    }

}
