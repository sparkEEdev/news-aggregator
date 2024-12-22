<?php

namespace App\Core\V1\Article\Actions;

use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Core\v1\Article\Resources\ArticleResource;

class GetArticleAction
{
    /**
     * Get all categories.
     *
     * @param string $slug
     * @return ArticleResource | JsonResponse
     */
    public function execute(string $slug): ArticleResource|JsonResponse
    {
        $data = Article::with(['categories', 'sources'])
            ->where('slug', $slug)->first();

        if (!$data) {
            return response()->json(
                ['message' => 'Article not found'],
                Response::HTTP_NOT_FOUND,
            );
        }

        return new ArticleResource($data);
    }
}
