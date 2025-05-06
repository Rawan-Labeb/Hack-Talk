<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('apiResponse')) {
    function apiResponse($status, $message, $data = null): JsonResponse
    {
        $response = array_filter([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], fn($value) => $value !== null);
        return response()->json($response);
    }
}

if (!function_exists('mediaUploadHandling')) {
    function mediaUploadHandling($request): array|JsonResponse
    {
        $folderPath = 'uploads/Images';
        try {
            $originalExtension = $request->file('file')->getClientOriginalExtension();
            $originalName = time() . '.' . $request->file('file')->getClientOriginalName();
            if ($originalExtension == 'pdf' || $originalExtension == 'PDF') {
                $folderPath = 'uploads/PDFs';
            }
            $destinationPath = public_path($folderPath);
            $request->file('file')->move($destinationPath, $originalName);
            return [
                'name' => $originalName,
                'path' => $folderPath . '/' . $originalName,
                'extension' => $originalExtension
            ];
        }
        catch (\Exception $e) {
            return apiResponse(500, "Media upload failed . {$e->getMessage()}");
        }
    }
}
