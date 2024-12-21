<?php

namespace App\Services\NewsAggregator\DTO;

use App\Services\NewsAggregator\DTO\SourceDTO;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ArticleDTO
{
    public function __construct(
        private ?string $author,
        private string $title,
        private ?string $description,
        private ?string $content,
        private string $url,
        private string $publishedAt,
        private ?SourceDTO $source,
    ) {
    }

    static function fromNewsOrgData(array $data): ArticleDTO
    {
        return new ArticleDTO(
            author: $data['author'],
            title: $data['title'],
            description: $data['description'],
            content: $data['content'],
            url: $data['url'],
            publishedAt: Carbon::parse($data['publishedAt']),
            source: SourceDTO::fromNewsOrgData($data['source']),
        );
    }

    static function fromGuardianComData(array $data): ArticleDTO
    {
        $author = array_filter($data['tags'], function ($tag) {
            return $tag['type'] === 'contributor';
        });

        return new ArticleDTO(
            author: $author[0]['webTitle'] ?? '',
            title: $data['webTitle'] ?? '',
            description: $data['description'] ?? '',
            content: $data['content'] ?? '',
            url: $data['webUrl'] ?? '',
            publishedAt: $data['webPublicationDate'] ?? '',
            source: null,
        );
    }

    static function fromTheNewsApiComData(array $data): ArticleDTO
    {
        return new ArticleDTO(
            author: null,
            title: $data['title'] ?? '',
            description: $data['description'] ?? '',
            content: $data['snippet'] ?? '',
            url: $data['url'] ?? '',
            publishedAt: $data['published_at'] ?? '',
            source: null,
        );
    }

    public function toModel(): array
    {
        return [
            'author' => $this->author,
            'slug' => $this->slug(),
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'url' => $this->url,
            'published_at' => $this->publishedAt,
        ];
    }

    public function source(): SourceDTO
    {
        return $this->source;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function slug(): string
    {
        return Str::slug($this->title, '-');
    }

}
