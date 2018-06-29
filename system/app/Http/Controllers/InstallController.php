<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\InstallService;
use App\Http\Requests\InstallRequest;
use Illuminate\Support\Facades\DB;

class InstallController extends Controller
{
    protected $installService;

    public function __construct(InstallService $installService)
    {
        $this->installService = $installService;
    }

    public function index(Request $request)
    {
        if ($this->installService->installedAlready()) {
            // abort(404);
        }

        return response()->view('setup.install');
    }

    public function install(InstallRequest $request)
    {
        $validatedData = $request->validated();

        $this->installService->install($validatedData);

        return redirect()->route('admin:index');
    }

    public function testDatabase()
    {
        try {
            DB::connection()->getPdo();
            if (DB::connection()->getDatabaseName()) {
                return redirect()->route('setup:success');
            }
        } catch (\Exception $e) {
            return redirect()->route('setup:install-form')->with('db-error', 'A connection to the database could not be instantiated.');
        }
    }
}
