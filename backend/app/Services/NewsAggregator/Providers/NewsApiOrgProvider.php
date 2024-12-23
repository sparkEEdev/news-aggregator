<?php

namespace App\Services\NewsAggregator\Providers;

use Throwable;
use App\Models\Source;
use GuzzleHttp\Client;
use App\Models\Article;
use App\Models\Category;
use App\Enums\DataSources;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;
use \Psr\Http\Client\ClientInterface;
use App\Services\NewsAggregator\DTO\SourceDTO;
use App\Services\NewsAggregator\DTO\ArticleDTO;
use App\Services\NewsAggregator\Exceptions\InvalidValueException;
use App\Services\NewsAggregator\Interfaces\NewsProviderInterface;


class NewsApiOrgProvider implements NewsProviderInterface
{
    private string $baseUrl = 'https://newsapi.org/v2';

    private int $pageSize = 100;

    private string $apiKey = '';

    /**
     * @property ClientInterface $client
     */
    private ClientInterface $client;

    public function __construct()
    {
        $this->client = new Client();

        $this->apiKey = config("services." . DataSources::NEWS_API_ORG->value . ".api_key");
    }

    private function getHeaders(): array
    {
        return [
            'X-Api-Key' => $this->apiKey,
        ];
    }

    public function crawl(callable $callback): void
    {
        $sources = $this->crawlSources();
        $articles = $this->crawlArticles($sources);

        $this->processSources($sources);

        $this->processArticles($articles);

        $callback();
    }

    /**
     * @param SourceDTO[] $sourcesQuery
     * @return ArticleDTO[]
     */
    private function crawlArticles(array $sources): array
    {
        $page = 1;

        $headlines = [];

        $limitedSources = array_map(function (SourceDTO $source) {
            return $source->slug();
        }, $sources);

        $sourcesQuery = implode(',', $limitedSources);

        while (true) {
            $articles = $this->getArticles($sourcesQuery, $page);

            if (empty($articles)) {
                break;
            }

            $headlines = array_merge($headlines, $articles);

            $page++;
        }

        return $headlines;
    }

    /**
     * @return ArticleDTO[]
     */
    private function getArticles(string $sourcesQuery, int $page): array
    {
        try {
            $response = $this->client->sendRequest(
                new Request(
                    method: 'GET',
                    uri: "$this->baseUrl/top-headlines?sources=$sourcesQuery&pageSize=$this->pageSize&page=$page",
                    headers: $this->getHeaders(),
                ),
            );

            $data = json_decode($response->getBody()->getContents(), true);

            // Dev api keys are only allowed first 100 results
            if ($data['status'] !== 'ok') {
                return [];
            }

            $articles = [];

            foreach ($data['articles'] as $article) {
                $articles[] = ArticleDTO::fromNewsOrgData($article);
            }

            return $articles;

        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return [];
        }
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
            $sources[] = SourceDTO::fromNewsOrgData($source);
        }

        return $sources;
    }

    /**
     * @param SourceDTO[] $sources
     */
    private function processSources($sources): void
    {
        foreach ($sources as $sourceDTO) {

            if (!($sourceDTO instanceof SourceDTO)) {
                throw new InvalidValueException('SourceDTO expected');
            }

            $source = Source::where('slug', $sourceDTO->slug())->first();

            if (!$source) {
                $source = Source::create($sourceDTO->toModel());
            }

            $category = Category::where('slug', $sourceDTO->category())->first();

            if (!$category) {
                $category = Category::create([
                    'slug' => $sourceDTO->category(),
                    'name' => $sourceDTO->category(),
                ]);
            }

            $source->categories()->sync($category);
        }
    }

    /**
     * @param ArticleDTO[] $articles
     */
    private function processArticles($articles): void
    {
        foreach ($articles as $articleDTO) {
            if (!($articleDTO instanceof ArticleDTO)) {
                throw new InvalidValueException('ArticleDTO expected');
            }

            $sourceDTO = $articleDTO->source();

            $article = Article::where('slug', $articleDTO->slug())->first();

            if (!$article) {
                $article = Article::create($articleDTO->toModel());
            }

            $source = Source::with('categories')->where('slug', $sourceDTO->slug())->first();

            if ($source) {
                $article->sources()->sync($source);
                $article->categories()->sync($source->category);
            }
        }
    }
}
