<?php

namespace App\Services\NewsAggregator\Providers;

use App\Services\NewsAggregator\DTO\ArticleDTO;
use App\Services\NewsAggregator\DTO\SourceDTO;
use GuzzleHttp\Client;
use \Psr\Http\Client\ClientInterface;
use GuzzleHttp\Psr7\Request;
use App\Services\NewsAggregator\Interfaces\NewsProviderInterface;
use App\Enums\DataSources;

class NewsApiOrgProvider implements NewsProviderInterface
{
    private string $baseUrl = 'https://newsapi.org/v2';

    private int $pageSize = 100;

    private string $apiKey = '';


    private function getHeaders(): array
    {
        return [
            'X-Api-Key' => $this->apiKey,
        ];
    }

    /**
     * @property ClientInterface $client
     */
    private ClientInterface $client;

    public function __construct()
    {
        $this->client = new Client();

        $this->apiKey = config("services." . DataSources::NEWS_API_ORG->value . ".api_key");
    }

    public function crawl(callable $callback): void
    {
        $sources = $this->crawlSources();
        $headlines = $this->crawlArticles($sources);


        $callback($sources, $headlines);
    }

    /**
     * @param SourceDTO[] $sources
     * @return ArticleDTO[]
     */
    private function crawlArticles(array $sourceDTOs): array
    {
        $headlines = [];

        $limitOfSources = 5;

        $limitedSources = array_map(function (SourceDTO $source) {
            return $source->slug();
        }, array_slice($sourceDTOs, 0, $limitOfSources));

        $sources = implode(',', $limitedSources);

        $response = $this->client->sendRequest(
            new Request(
                method: 'GET',
                uri: "$this->baseUrl/top-headlines?sources=$sources",
                headers: $this->getHeaders(),
            ),
        );

        $data = json_decode($response->getBody()->getContents(), true);

        foreach ($data['articles'] as $article) {
            $headlines[] = ArticleDTO::fromArray($article);
        }

        return $headlines;
    }

    /**
     * @return SourceDTO[]
     */
    private function crawlSources(): array
    {
        $response = $this->client->sendRequest(
            new Request(
                method: 'GET',
                uri: "$this->baseUrl/top-headlines/sources",
                headers: $this->getHeaders(),
            ),
        );

        $data = json_decode($response->getBody()->getContents(), true);

        $sources = [];

        foreach ($data['sources'] as $source) {
            $sources[] = SourceDTO::fromArray($source);
        }

        return $sources;
    }

    public function crawlFoods(callable $callback): void
    {
        // foreach ($this->foodGroupUrls as $groupUrl) {
        //     $crawler = $this->client->request('GET', $this->baseUrl . $groupUrl);

        //     $groupName = $crawler->filter('.title')->text();

        //     $crawler->filter('.food_links > a')->each(function ($node) use ($groupName, $callback) {

        //         $this->foodUrls[] = $node->attr('href');
        //         $name = $node->text();

        //         $callback(new FoodDTO($name, '', $groupName));
        //     });

        //     sleep(3);
        // }
    }

    public function crawlFoodNutrients(callable $callback): void
    {
        //
    }
}
