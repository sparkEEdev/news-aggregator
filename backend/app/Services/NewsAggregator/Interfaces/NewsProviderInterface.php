<?php

namespace App\Services\NewsAggregator\Interfaces;

use App\Enums\DataSources;


interface NewsProviderInterface
{
    /**
     * @param callable(): void $callback
     * @return void
     */
    public function crawl(callable $callback): void;
}
