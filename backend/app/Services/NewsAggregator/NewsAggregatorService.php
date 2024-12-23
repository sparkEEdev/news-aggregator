<?php

namespace App\Services\NewsAggregator;

use App\Enums\DataSources;
use App\Services\NewsAggregator\Providers\NewsApiOrgProvider;
use App\Services\NewsAggregator\Providers\TheNewsApiComProvider;
use App\Services\NewsAggregator\Interfaces\NewsProviderInterface;
use App\Services\NewsAggregator\Providers\TheGuardianComProvider;

class NewsAggregatorService
{
    private NewsProviderInterface $provider;

    public function __construct(DataSources $source)
    {
        switch ($source) {
            case DataSources::NEWS_API_ORG:
                $this->provider = new NewsApiOrgProvider();
                break;
            case DataSources::THE_GUARDIAN_COM:
                $this->provider = new TheGuardianComProvider();
                break;
            case DataSources::THE_NEWS_API_COM:
                $this->provider = new TheNewsApiComProvider();
                break;
            default:
                throw new \Exception('Unimplemented data source');
        }
    }

    public function process()
    {
        $this->provider->crawl(function () {
            // Log::info('Crawling completed');
        });
    }
}
