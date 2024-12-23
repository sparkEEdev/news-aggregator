<?php

namespace App\Core\v1\Article\Controllers;

use Illuminate\Routing\Controller;
use App\Core\v1\Article\Actions\GetArticleAction;
use App\Core\V1\Article\Actions\GetArticlesAction;
use App\Core\v1\Article\Requests\GetArticlesRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GetArticlesRequest $request
     * @param GetArticlesAction $action
     * @return \App\Core\v1\Article\Resources\LimitedArticleCollection
     */
    public function index(GetArticlesRequest $request, GetArticlesAction $action)
    {
        return $action->execute($request);
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @param GetArticleAction $action
     * @return \App\Core\v1\Article\Resources\ArticleResource
     */
    public function show(string $slug, GetArticleAction $action)
    {
        return $action->execute($slug);
    }
}
