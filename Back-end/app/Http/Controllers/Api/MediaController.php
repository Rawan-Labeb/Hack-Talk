<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadMediaRequest;

class MediaController extends Controller
{
    public function store(UploadMediaRequest $request)
    {
        try {
            $mediaInformation = mediaUploadHandling($request);
            auth()->user()->media()->create([
                'path' => $mediaInformation['path'],
                'name' => $mediaInformation['name'],
                'type' => $mediaInformation['extension']
            ]);
        } catch (\Exception $e) {
            return apiResponse(500, "Server Internal Error: . {$e->getMessage()}");
        }
        return apiResponse(200, 'Media uploaded successfully');
    }
}
