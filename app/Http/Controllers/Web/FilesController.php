<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Files;
use App\Models\Resize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class FilesController extends Controller
{
    public function list()
    {
        $files = Files::all();

        return Inertia::render('Files', [
            'files' => $files,
        ]);
    }

    public function upload()
    {
        return Inertia::render('Upload');
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');

        $uniqid = uniqid();

        $data = [
            'app_id' => 1,
            'file_id' => $uniqid,
            'name' => $file->getClientOriginalName(),
            'path' => 'files/' . $uniqid . '/' . $file->getClientOriginalName(),
            'extension' => $file->getClientOriginalExtension(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'disk' => 'ftp',
            'url' => Storage::disk('ftp')->url('files/' . $uniqid . '/' . $file->getClientOriginalName()),
        ];

        if (Storage::disk('ftp')->put('files/' . $uniqid . '/' . $file->getClientOriginalName(), file_get_contents($file))) {
            Files::create($data);
            $image = Resize::where('file_id', $uniqid)->first();
            $image_set[] = $image;
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'File gagal diupload',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'File berhasil diupload',
            'data' => $data,
        ]);
    }

    public function delete(Request $request)
    {
        $validator = $request->validate([
            'id' => 'required|string',
        ]);

        $file = Files::where('file_id', $request->id)->first();

        if ($file) {
            if (Storage::disk('ftp')->deleteDirectory('files/' . $request->id)) {
                $file->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'File berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File gagal dihapus',
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'File tidak ditemukan',
            ]);
        }
    }

    public function download($id)
    {
        $file = Files::where('file_id', $id)->first();

        return response()->streamDownload(function () use ($file) {
            echo file_get_contents($file->url);
        }, $file->name, [
            'Content-Type' => $file->mime_type,
            'Content-Length' => $file->size,
            'Content-Disposition' => 'attachment; filename="' . $file->name . '"',
        ]);
    }
}
