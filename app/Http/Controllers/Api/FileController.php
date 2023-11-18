<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');

        $path = $file->store('public');

        $newFile = File::create([
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
        ]);

        return response()->json(['url' => $newFile->path]);
    }
}
