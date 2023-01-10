<?php

namespace App\Http\Controllers;


use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $path = $request->file('file')?->store('test');
        $file = File::query()->create([
            'path' => $path,
            'slug'=> uniqid('file-',true),
        ]);
        return response()->json([
            'slug' => $file->slug,
        ]);
    }

    public function getFile(string $slug): string
    {
        $file = File::query()->firstWhere('slug', $slug);
        if(!$file) return '';
        return Storage::url($file->path);
    }

    public function show(string $slug)
    {
        $file = File::query()->firstWhere('slug', $slug);
        if(!$file) return '';
        return response()->json([
            'path' => url($file->path),
        ]);
    }
}
