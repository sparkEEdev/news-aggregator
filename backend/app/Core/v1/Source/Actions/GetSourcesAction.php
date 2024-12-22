<?php

namespace App\Core\V1\Source\Actions;

use App\Models\Source;
use App\Core\v1\Source\Requests\GetSourcesRequest;
use App\Core\v1\Source\Resources\SourceCollection;

class GetSourcesAction
{
    /**
     * Get all categories.
     *
     * @return SourceCollection
     */
    public function execute(GetSourcesRequest $request): SourceCollection
    {
        $searchQuery = $request->validated('search');
        $perPage = $request->validated('per_page', 10);
        $page = $request->validated('page', 1);

        $data = Source::when($searchQuery, function ($query, $search) {
            return $query
                ->where('name', 'LIKE', "%$search%")
                ->orWhere('description', 'LIKE', "%$search%")
                ->orWhere('url', 'LIKE', "%$search%");
        })->paginate(
                perPage: $perPage,
                page: $page,
            );


        return new SourceCollection($data);
    }
}
