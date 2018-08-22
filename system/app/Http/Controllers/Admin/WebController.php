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
        $needsUpdate = $this->updateService->needsUpdate();

        return view('admin.index', [
            'packages'    => $packages,
            'needsUpdate' => $needsUpdate,
            'version'     => wpls_version()
        ]);
    }

    /**
     * Get the scripts needed for the dashboard.
     *
     * @return Illuminate\Http\Response
     */
    public function scripts(Request $request)
    {
        $response = Response::make(Storage::disk('assets')->get('js/index.js'));
        $response->header('Content-Type', 'application/javascript; charset=UTF-8');
        return $response;
    }

    /**
     * Get the CSS for the dashboard.
     *
     * @return Illuminate\Http\Response
     */
    public function css(Request $request)
    {
        $response = Response::make(Storage::disk('assets')->get('css/index.css'));
        $response->header('Content-Type', 'text/css');
        return $response;
    }
}
