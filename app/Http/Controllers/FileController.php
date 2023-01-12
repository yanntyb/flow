<?php

namespace App\Http\Controllers;


use App\Models\File\Connector\FromUploadUrl;
use App\Models\File\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $path = $request->file('file')?->storePublicly('file','public');
        $file = File::query()->create([
            'path' => 'storage/' . $path,
            'slug'=> uniqid('file-',true),
            'connected_with' => FromUploadUrl::class,
            'connected_data' => FromUploadUrl::getConnectedData(),
            'need_connector' => true,
        ]);
        return response()->json([
            'slug' => $file->slug,
        ]);
    }

    public function getFile(string $slug): string
    {
        /**
         * @var File $file
         */
        $file = File::query()->where('slug',$slug)->firstOrFail();
        if(!$file?->connector->canBeAccessed()){
            abort(403);
        }
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
