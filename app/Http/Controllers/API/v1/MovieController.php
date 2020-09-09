<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\APIController;
use App\Models\Movie;
use App\Repositories\Interfaces\IPieMDBDataSourceRepository;
use App\Services\Interfaces\IDataSyncService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MovieController extends APIController
{
    public function index()
    {
        $data = Movie::all();

        $dummyOutputCollection = collect([]);
        $data->each(function ($item) use (&$dummyOutputCollection){
            $dummyOutputCollection->push(json_decode($item->entry));
        });

        return \response()->json($dummyOutputCollection);
    }
}
