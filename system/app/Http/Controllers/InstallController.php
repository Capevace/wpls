<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\InstallService;
use App\Http\Requests\InstallRequest;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Session;

class InstallController extends Controller
{
    protected $installService;

    public function __construct(InstallService $installService)
    {
        $this->installService = $installService;

        $this->middleware('installed');
    }

    public function index(Request $request)
    {
        $error = $request->input('error', null);

        if (!empty($error))
            return response()->view('setup.install', [
                'error' => $error
            ]);

        return response()->view('setup.install');
    }

    public function install(Request $request)
    {
        $data = [
            'db_host' => $request->input('db_host', '127.0.0.1'),
            'db_port' => $request->input('db_port', '3306'),
            'db_database' => $request->input('db_database', 'wpls'),
            'db_user' => $request->input('db_user', 'root'),
            'db_pass' => $request->input('db_pass', ''),
            'app_url' => $request->input('app_url', ''),
            'envato_api_key' => $request->input('envato_api_key', ''),
            'update_password' => $request->input('update_password', '')
        ];

        $this->installService->createEnv($data);

        return redirect()->route('setup:test-db');
    }

    public function testDatabase()
    {
        try {
            DB::connection()->getPdo();
            if (DB::connection()->getDatabaseName()) {
                return redirect()->route('setup:success');
            }
        } catch (\Exception $e) {
            Session::flash('message', "Special message goes here");
            return redirect()->route('setup:install-form', [
                'error' => 'A database connection could not be established. Please check your credentials.'
            ]);
        }
    }

    public function success()
    {
        // Migrate database, force flag is necessary because the APP_ENV is production
        $output = $this->installService->setupDatabase();

        return view('setup.success', [
            'output' => $output
        ]);
    }

    public function createAdminAccount(Request $request)
    {
        $validatedData = $request->validate([
            'admin_name'     => 'required|string',
            'admin_username' => 'required|string',
            'admin_email'    => 'required|email',
            'admin_password' => 'required|string'
        ]);

        $this->installService->createAdminAccount($validatedData);
        $this->installService->finishInstallation();

        return redirect()->route('admin:index');
    }
}
