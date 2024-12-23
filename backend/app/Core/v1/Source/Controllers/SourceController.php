<?php

namespace App\Core\v1\Source\Controllers;

use Illuminate\Routing\Controller;
use App\Core\V1\Source\Actions\GetSourcesAction;
use App\Core\v1\Source\Requests\GetSourcesRequest;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \App\Core\v1\Source\Resources\SourceCollection
     */
    public function index(GetSourcesRequest $request, GetSourcesAction $action)
    {
        return $action->execute($request);
    }
}
