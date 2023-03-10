<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AppAccess;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppAccessController extends Controller
{
    public function list()
    {
        $app_access = AppAccess::all();

        return Inertia::render('AppAccess', [
            'app_access' => $app_access,
        ]);
    }
}
