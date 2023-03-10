<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AppAccess;
use App\Models\Files;
use App\Models\Resize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $validator = $request->validate([
            'file.*' => 'required|file',
            'token' => 'required|string',
        ]);

        # Cek Token Apakah Sudah Terdaftar
        $token = AppAccess::where('token', $request->token)->first();

        if ($token) {

            # Tipe Array jika lebih dari 1 file
            $data_set = array();
            $image_set = array();
            # End of Tipe Array jika lebih dari 1 file

            # Upload File bisa lebih dari 1
            foreach ($request->file as $file) {
                $uniqid = uniqid();
                $data = [
                    'app_id' => $token->id,
                    'file_id' => $uniqid,
                    'name' => $file->getClientOriginalName(),
                    'path' => 'files/' . $token->id . '/' . $uniqid . '/' . $file->getClientOriginalName(),
                    'extension' => $file->getClientOriginalExtension(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'disk' => 'ftp',
                    'url' => Storage::disk('ftp')->url('files/' . $token->id . '/' . $uniqid . '/' . $file->getClientOriginalName()),
                ];

                $data_set[] = $data;

                if (Storage::disk('ftp')->put('files/' . $token->id . '/' . $uniqid . '/' . $file->getClientOriginalName(), file_get_contents($file))) {
                    Files::create($data);
                    $image = Resize::where('file_id', $uniqid)->first();
                    $image_set[] = $image;
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'File gagal diupload',
                    ]);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'File berhasil diupload',
                'data' => $data_set,
                'resize_image' => $image_set,
            ]);
        } else {
            # Token Tidak Terdaftar
            return response()->json([
                'status' => 'error',
                'message' => 'Token tidak valid',
            ]);
        }
    }
}
