<?php

namespace App\Http\Controllers\Api;

use App\Constants\AuthenConstant\StatusResponse;
use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $uploadedFile = $request->file('file');

        $result = Cloudinary::upload($uploadedFile->getRealPath(), []);

        $url = $result['secure_url'];

        return response()->json([
            'url' => $url
        ], StatusResponse::SUCCESS);

    }
}
