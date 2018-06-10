<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Package;

class WebController extends Controller
{
    public function index()
    {
        $packages = Package::all();

        return view('admin.index', ['packages' => $packages]);
    }
}
