<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AppAccess;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function create(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|string',
            'url' => 'required|string',
        ]);

        $token = bin2hex(random_bytes(20));

        $tokens = AppAccess::where('token', $token)->count();
        // loop generate token until token is unique
        while ($tokens > 0) {
            $token = bin2hex(random_bytes(20));
            $tokens = AppAccess::where('token', $token)->count();
        }

        # Create database
        $url = AppAccess::where('url', $request->url)->first();
        if ($url) {
            return response()->json([
                'status' => 'error',
                'message' => 'URL already exists',
            ], 400);
        } else {
            $app_access = AppAccess::create([
                'name' => $request->name,
                'url' => $request->url,
                'token' => $token,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully created',
                'data' => $app_access,
            ]);
        }
    }

    public function delete(Request $request)
    {
        $validator = $request->validate([
            'token' => 'required|string',
        ]);

        $token = AppAccess::where('token', $request->token)->first();

        if ($token) {
            $token->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully deleted',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Token not found',
            ], 404);
        }
    }

    public function webcreate(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|string',
            'domain' => 'required|string',
        ]);

        $token = bin2hex(random_bytes(20));

        $tokens = AppAccess::where('token', $token)->count();

        while ($tokens > 0) {
            $token = bin2hex(random_bytes(20));
            $tokens = AppAccess::where('token', $token)->count();
        }

        # Create database
        $url = AppAccess::where('url', $request->domain)->first();

        if ($url) {
            return response()->json([
                'status' => 'error',
                'message' => 'Domain already exists',
            ], 400);
        } else {
            $app_access = AppAccess::create([
                'name' => $request->name,
                'url' => $request->domain,
                'token' => $token,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully created',
                'data' => $app_access,
            ]);
        }
    }
}
