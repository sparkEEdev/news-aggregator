<?php

namespace App\Services\NewsAggregator\Providers;

use App\Services\NewsAggregator\DTO\FoodDTO;
use App\Services\NewsAggregator\DTO\FoodGroupDTO;
use App\Services\NewsAggregator\Interfaces\NewsProviderInterface;


/**
 * Class FoodSeederProvider
 *
 * Use this class during development of the FoodService class to avoid making making external calls.
 */
class NewsSeederProvider implements NewsProviderInterface
{
    public function crawl(callable $callback): void
    {
        $callback([], []);
    }
}
