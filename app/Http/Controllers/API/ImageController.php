<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Files;
use App\Models\Resize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function resize($file_id, $width, $height, $crop=false)
    {
        $validator = Validator::make([
            'file_id' => $file_id,
            'width' => $width,
            'height' => $height,
            'crop' => $crop,
        ], [
            'file_id' => 'required|string',
            'width' => 'integer|nullable',
            'height' => 'integer|nullable',
            'crop' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
            ], 400);
        }

        $files = Files::where('file_id', $file_id)->first();
        $name = explode('.', $files->name);
        $name = $name[0] . '-' . $width . 'x' . $height . '.jpg';

        # Download Image from storage
        $image = file_get_contents($files->url);

        # Make image
        $image = Image::make($image);

        # Resize Images with width and height
        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        if ($width == null) {
            $width = 0;
        }
        if ($height == null) {
            $height = 0;
        }

        # Send to storage disk
        Storage::disk('ftp')->put('files/' . $files->app_id . '/' . $file_id . '/' . $name, $image->stream());

        # Delete image
        $image->destroy();

        $images = Image::make(Storage::disk('ftp')->get('files/' . $files->app_id . '/' . $file_id . '/' . $name));

        $path = public_path('images/');
        $width = $images->width();
        $height = $images->height();
        $size = $images->filesize();
        # Data to update to database
        $data = [
            'file_id' => $file_id,
            'name' => $name,
            'path' => 'files/' . $files->app_id . '/' . $file_id . '/' . $name,
            'extension' => $files->extension,
            'mime_type' => $files->mime_type,
            'size' => $size,
            'disk' => 'ftp',
            'width' => $width,
            'height' => $height,
            'url' => Storage::disk('ftp')->url('files/' . $files->app_id . '/' . $file_id . '/' . $name),
            'created_at' => now(),
        ];

        # Insert to database
        Resize::create($data);

        return response()->stream(function () use ($images) {
            echo $images->stream();
        }, 200, [
            'Content-Type' => $images->mime(),
            'Content-Disposition' => 'inline; filename="' . $name . '"',
        ]);
    }
}
