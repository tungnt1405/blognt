<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WebInfoResource;
use App\Models\Config;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function common()
    {
        $webInfo = Config::all();
        return response()->json([
            "data" => $webInfo->count() > 0 ? new WebInfoResource(Config::all()->first()) : ['status_maintain' => false]
        ]);
    }
}
