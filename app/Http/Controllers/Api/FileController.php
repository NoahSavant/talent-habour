<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');

        $path = $file->store('public');
        $url = Storage::url($path);

        $newFile = File::create([
            'filename' => $file->getClientOriginalName(),
            'path' => $url,
        ]);

        return response()->json(['url' => $url]);
    }
}
