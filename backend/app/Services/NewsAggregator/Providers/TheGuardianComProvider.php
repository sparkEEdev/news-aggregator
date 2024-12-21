<?php

namespace App\Services\NewsAggregator\Providers;

use Log;
use Throwable;
use App\Models\Source;
use GuzzleHttp\Client;
use App\Models\Article;
use App\Models\Category;
use App\Enums\DataSources;
use GuzzleHttp\Psr7\Request;
use \Psr\Http\Client\ClientInterface;
use App\Services\NewsAggregator\DTO\ArticleDTO;
use App\Services\NewsAggregator\Exceptions\InvalidValueException;
use App\Services\NewsAggregator\Interfaces\NewsProviderInterface;

class TheGuardianComProvider implements NewsProviderInterface
{
    private string $baseUrl = 'https://content.guardianapis.com';

    private string $apiKey = '';

    /**
     * @property ClientInterface $client
     */
    private ClientInterface $client;

    public function __construct()
    {
        $this->client = new Client();

        $this->apiKey = config("services." . DataSources::THE_GUARDIAN_COM->value . ".api_key");
    }

    public function crawl(callable $callback): void
    {
        $articles = $this->crawlArticles();

        $this->processArticles($articles);

        $callback();
    }

    /**
     *
     * @return ArticleDTO[]
     */
    private function crawlArticles(): array
    {
        $page = 1;

        $headlines = [];


        while (true) {
            $articles = $this->getArticles($page);

            if (empty($articles) || $page >= 5) {
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
    private function getArticles(int $page): array
    {
        try {
            $response = $this->client->sendRequest(
                new Request(
                    method: 'GET',
                    uri: "$this->baseUrl/search?api-key=$this->apiKey&page=$page&show-tags=contributor",
                ),
            );

            $data = json_decode($response->getBody()->getContents(), true);

            if ($data['response']['status'] !== 'ok') {
                return [];
            }

            $articles = [];

            foreach ($data['response']['results'] as $article) {
                $articles[] = ArticleDTO::fromGuardianComData($article);
            }

            return $articles;
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return [];
        }
    }

    /**
     * @param ArticleDTO[] $articles
     */
    private function processArticles($articles): void
    {
        $sources = Source::all();
        $categories = Category::all();

        foreach ($articles as $articleDTO) {
            if (!($articleDTO instanceof ArticleDTO)) {
                throw new InvalidValueException('ArticleDTO expected');
            }

            $article = Article::where('slug', $articleDTO->slug())->first();

            if (!$article) {
                $article = Article::create($articleDTO->toModel());
            }

            $randomSource = $sources[array_rand($sources->toArray())];
            $randomCategory = $categories[array_rand($categories->toArray())];

            $article->source()->sync($randomSource);
            $article->category()->sync($randomCategory);
        }
    }
}
