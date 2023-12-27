<?php

namespace App\Http\Controllers\Api;

use App\Constants\AuthenConstant\StatusResponse;
use App\Http\Controllers\Controller;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $result = Cloudinary::upload($request->file('file')->getRealPath(), [
            'folder' => 'files',
        ]);

        $url = $result->getSecurePath();

        return response()->json([
            'url' => $url,
        ], StatusResponse::SUCCESS);
    }
}
