<?php

namespace App\Http\Controllers;

use App\Jobs\ApiCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApiController extends Controller
{
    public function check(Request $request)
    {
        $numero_id = $request->numero_id;
        $numero_cnaas = $request->numero_cnaas;

        ApiCheck::dispatch($numero_id, $numero_cnaas);
        return 'verified';
    }
    public function verify(Request $request)
    {
        $numero_id = $request->numero_id;
        $numero_cnaas = $request->numero_cnaas;

        return Cache::remember("api_check_{$numero_id}_{$numero_cnaas}", 20, function () {
            return random_int(1, 120);
        });

    }
}
