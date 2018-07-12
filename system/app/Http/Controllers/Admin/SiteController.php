<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site;

class SiteController extends Controller
{
    /**
     * Get all Sites, filter them by date and return them as json.
     *
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $query = Site::select('sites.*'); // Weird fix so the Eloquent Model returns a query so the filtering works

        $output = filterQueryForDataTable($query, $request);

        return response()->json($output);
    }
}
