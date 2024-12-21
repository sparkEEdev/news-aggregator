<?php

namespace App\Services\NewsAggregator;

use Carbon\Carbon;
use App\Services\NewsAggregator\DTO\SourceDTO;
use App\Services\NewsAggregator\DTO\ArticleDTO;
use App\Services\NewsAggregator\Exceptions\InvalidValueException;
use App\Services\NewsAggregator\Interfaces\NewsProviderInterface;
use Exception;

class NewsAggregatorService
{
    private NewsProviderInterface $provider;

    public function __construct(NewsProviderInterface $provider)
    {
        $this->provider = $provider;
    }


    public function process()
    {
        $this->provider->crawl(function ($sources, $articles) {

            // $this->processSources($sources);

            // $this->processArticles($articles);
        });
    }

    /**
     * @param SourceDTO[] $sources
     */
    private function processSources($sources): void
    {
        throw new Exception('Not implemented');
    }

    /**
     * @param ArticleDTO[] $articles
     */
    private function processArticles($articles): void
    {
        throw new Exception('Not implemented');
    }
}
