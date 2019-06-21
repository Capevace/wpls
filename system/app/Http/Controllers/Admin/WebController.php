<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Setup\UpdateService;

use App\Models\Package;
use Storage;
use Response;

class WebController extends Controller
{
    protected $updateService;

    public function __construct(UpdateService $updateService)
    {
        $this->updateService = $updateService;
    }
    /**
     * Get the admin dashboard view.
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $packages    = Package::all();
        // $needsUpdate = $this->updateService->needsUpdate();

        return view('admin.index', [
            'packages'    => $packages,
            'needsUpdate' => false,
            'version'     => config('app.version')
        ]);
    }
}
