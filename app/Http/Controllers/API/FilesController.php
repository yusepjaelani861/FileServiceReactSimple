<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AppAccess;
use App\Models\Files;
use App\Models\Resize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    # List seluruh file milik app_id
    public function list(Request $request)
    {
        $validator = $request->validate([
            'p' => 'integer|nullable',
            'token' => 'required|string',
        ]);

        $token = AppAccess::where('token', $request->token)->first();

        # Cek apakah token tersebut ada atau tidak
        if ($token) {
            if ($request->p) {
                $files = Files::where('app_id', $token->id)->paginate($request->p);

                # Keterangan
                # $request->p = nilai pagination yang diinginkan, berbentuk integer

                return response()->json($files);
            } else {
                $files = Files::where('app_id', $token->id)->get();

                return response()->json($files);
            }
        } else {
            # Token tidak ditemukan
            return response()->json([
                'status' => 'error',
                'message' => 'Token not found',
            ], 404);
        }
    }

    # Rename file sesuai pemilik app_id, bila bukan pemilik app_id, maka tidak bisa rename
    public function rename(Request $request)
    {
        $validator = $request->validate([
            'file_id' => 'required|string',
            'name' => 'required|string',
            'token' => 'required|string',

        ]);

        $token = AppAccess::where('token', $request->token)->first();

        # Cek apakah token tersebut ada atau tidak
        if ($token) {
            $files = Files::where('app_id', $token->id)->where('file_id', $request->file_id)->first();

            # Cek apakah ada extension file atau tidak pada nama file yang baru
            $cek = substr($request->name, strrpos($request->name, '.') + 1);
            if ($cek == $files->extension) {

                # Rename file pada database
                $files->name = $request->name;
                $files->save();
                # End of rename file pada database

                return response()->json([
                    'status' => 'success',
                    'message' => 'Nama file berhasil diubah',
                ], 200);
            } else {
                # Rename file pada database
                $files->name = $request->name . '.' . $files->extension;
                $files->save();
                # End of rename file pada database

                return response()->json([
                    'status' => 'success',
                    'message' => 'Nama file berhasil diubah',
                ], 200);
            }
        } else {
            # Token tidak ditemukan
            return response()->json([
                'status' => 'error',
                'message' => 'Token not found',
            ], 404);
        }
    }

    # Delete file sesuai pemilik app_id, bila bukan pemilik app_id, maka tidak bisa delete
    public function delete(Request $request)
    {
        $validator = $request->validate([
            'file_id' => 'required|string',
            'token' => 'required|string',
        ]);

        $token = AppAccess::where('token', $request->token)->first();

        # Cek apakah token tersebut ada atau tidak
        if ($token) {
            $files = Files::where('app_id', $token->id)->where('file_id', $request->file_id)->first();

            # Delete file asli pada storage
            Storage::disk('ftp')->deleteDirectory('files/' . $files->app_id . '/' . $files->file_id);

            # Delete file pada database resize
            $resize = Resize::where('file_id', $request->file_id)->delete();

            # Delete file pada database
            $files->delete();
            # End of delete file pada database

            return response()->json([
                'status' => 'success',
                'message' => 'File berhasil dihapus'
            ]);
        } else {
            # Token tidak ditemukan
            return response()->json([
                'status' => 'error',
                'message' => 'Token not found',
            ], 404);
        }
    }

    public function search(Request $request)
    {
        $validator = $request->validate([
            'q' => 'required|string',
            'token' => 'required|string',
        ]);

        $token = AppAccess::where('token', $request->token)->first();

        # Cek apakah token tersebut ada atau tidak
        if ($token) {
            $files = Files::where('app_id', $token->id)->where('name', 'like', '%' . $request->q . '%')->paginate(10);

            # Keterangan
            # $request->search = isi yang mau dicari dengan pencarian filter pada nama file

            return response()->json($files);
        } else {
            # Token tidak ditemukan
            return response()->json([
                'status' => 'error',
                'message' => 'Token not found',
            ], 404);
        }
    }

    public function filter(Request $request)
    {
        $validator = $request->validate([
            'f' => 'required|string',
            'search' => 'required|string',
            'token' => 'required|string',
        ]);

        $token = AppAccess::where('token', $request->token)->first();

        # Cek apakah token tersebut ada atau tidak
        if ($token) {
            $files = Files::where($request->f, 'like', '%' . $request->search . '%')->get();

            # Keterangan
            # $request->f = nama yang mau di filter
            # $request->search = isi yang di filter

            return response()->json($files);
        } else {
            # Token tidak ditemukan
            return response()->json([
                'status' => 'error',
                'message' => 'Token not found',
            ], 404);
        }
    }

    public function getImage($file_id, Request $request)
    {
        $validator = $request->validate([
            'width' => 'integer|nullable',
            'height' => 'integer|nullable',
        ]);

        # Cek File Apakah Sudah Terdaftar
        $resize = Resize::where('file_id', $file_id)->first();
        $width = Resize::where('file_id', $file_id)->where('width', $request->input('width'))->first();
        $height = Resize::where('file_id', $file_id)->where('height', $request->input('height'))->first();
        $files = Files::where('file_id', $file_id)->first();
        # End of Cek File Apakah Sudah Terdaftar
        
        if ($files != null) {
            if ($width != null) {
                if ($width->width == $request->input('width')) {
                    return response()->stream(function () use ($width) {
                        echo file_get_contents($width->url);
                    }, 200, [
                        'Content-Type' => $width->mime_type,
                        'Content-Disposition' => 'inline; filename="' . $width->name . '"',
                    ]);
                }
            } else if ($height != null) {
                if ($height->height == $request->input('height')) {
                    return response()->stream(function () use ($height) {
                        echo file_get_contents($height->url);
                    }, 200, [
                        'Content-Type' => $height->mime_type,
                        'Content-Disposition' => 'inline; filename="' . $height->name . '"',
                    ]);
                }
            } else if (!$request->input('width') && !$request->input('height')) {
                return response()->stream(function () use ($files) {
                    echo file_get_contents($files->url);
                }, 200, [
                    'Content-Type' => $files->mime_type,
                    'Content-Disposition' => 'inline; filename="' . $files->name . '"',
                ]);
            } else {
                $image = (new ImageController)->resize($file_id, $request->input('width'), $request->input('height'), false);
    
                return $image;
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'File tidak ditemukan',
            ]);
        }
    }
}
