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

        // Get the original extension of the file
        $extension = $file->getClientOriginalExtension();

        // Generate a unique filename to avoid conflicts
        $fileName = uniqid() . '.' . $extension;

        // Store the file with the generated filename and the 'public' disk
        $path = $file->storeAs('public', $fileName);

        // Create a record in the database with the original filename and the stored path
        $newFile = File::create([
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
        ]);

        // Generate the URL based on the stored path
        $url = env('APP_URL') . Storage::url($path);

        return response()->json(['url' => $url]);
    }
}
