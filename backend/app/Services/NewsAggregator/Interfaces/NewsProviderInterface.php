<?php

namespace App\Services\NewsAggregator\Interfaces;

use App\Services\NewsAggregator\DTO\SourceDTO;
use App\Services\NewsAggregator\DTO\ArticleDTO;

interface NewsProviderInterface
{
    /**
     * @param callable(SourceDTO[], ArticleDTO[]): void $callback
     * @return void
     */
    public function crawl(callable $callback): void;

}
