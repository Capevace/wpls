<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Package;
use Storage;
use Response;

class WebController extends Controller
{
    public function index()
    {
        $packages = Package::all();

        return view('admin.index', ['packages' => $packages]);
    }

    public function scripts()
    {
        $response = Response::make(Storage::disk('assets')->get('js/index.js'));
        $response->header('Content-Type', 'application/javascript; charset=UTF-8');
        return $response;
    }

    public function css()
    {
        $response = Response::make(Storage::disk('assets')->get('css/index.css'));
        $response->header('Content-Type', 'text/css');
        return $response;
    }
}
