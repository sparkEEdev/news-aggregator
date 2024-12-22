<?php

namespace App\Core\V1\Category\Actions;

use App\Core\v1\Category\Resources\CategoryCollection;
use App\Models\Category;

class GetCategoriesAction
{
    /**
     * Get all categories.
     *
     * @return CategoryCollection
     */
    public function execute(): CategoryCollection
    {
        return new CategoryCollection(Category::all());
    }
}
