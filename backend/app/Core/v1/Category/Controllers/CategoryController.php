<?php

namespace App\Core\v1\Category\Controllers;

use App\Models\Category;
use App\Core\V1\Category\Actions\GetCategoriesAction;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \App\Core\v1\Category\Resources\CategoryCollection
     */
    public function index(GetCategoriesAction $action)
    {
        return $action->execute();
    }
}
