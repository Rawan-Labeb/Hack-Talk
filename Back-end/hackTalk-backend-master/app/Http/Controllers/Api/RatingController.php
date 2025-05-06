<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingStoreRequest;

class RatingController extends Controller
{
    public function store(RatingStoreRequest $request)
    {
        $authUser = auth()->user();
        try {
            $authUser->ratings()->create($request->validated());
            return apiResponse(201, "Thanks For Adding Your Rate!");

        } catch (\Exception $e) {
            return apiResponse(500, "Sorry Try Again Later");
        }
    }
}
