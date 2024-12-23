<?php

namespace App\Core\V1\Article\Actions;

use App\Models\Article;
use App\Core\v1\Article\Requests\GetArticlesRequest;
use App\Core\v1\Article\Resources\LimitedArticleCollection;

class GetArticlesAction
{
    /**
     * Get all categories.
     *
     * @param GetArticlesRequest $request
     * @return LimitedArticleCollection
     */
    public function execute(GetArticlesRequest $request): LimitedArticleCollection
    {
        $category = $request->validated('category_id');
        $source = $request->validated('source_id');
        $searchQuery = $request->validated('search');

        $perPage = $request->validated('per_page', 10);
        $page = $request->validated('page', 1);

        $data = Article::
            when($category, function ($query, $category) {
                return $query->whereHas('categories', function ($query) use ($category) {
                    $query->where('category_id', $category);
                });
            })
            ->when($source, function ($query, $source) {
                return $query->whereHas('sources', function ($query) use ($source) {
                    $query->where('source_id', $source);
                });
            })
            ->when($searchQuery, function ($query, $search) {
                return $query
                    ->where('title', 'LIKE', "%$search%")
                    ->orWhere('content', 'LIKE', "%$search%")
                    ->orWhere('description', 'LIKE', "%$search%")
                    ->orWhere('url', 'LIKE', "%$search%")
                    ->orWhere('author', 'LIKE', "%$search%");
            })->paginate(
                perPage: $perPage,
                page: $page,
            );


        return new LimitedArticleCollection($data);
    }
}
