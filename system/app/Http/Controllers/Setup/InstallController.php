<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\Setup\InstallService;
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


    /**
     * Show the initial install page, where the user has to enter their server information.
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        // Error passed on from page further down in the install process.
        // Done this way because default laravel error passing (back()->withErrors) doesn't seem to be working...
        $error = $request->input('error', null);

        // Render View
        if (!empty($error))
            return response()->view('setup.install', [
                'error' => $error
            ]);

        return response()->view('setup.install');
    }


    /**
     * POST Route to create the .env file required to connect to the database.
     *
     * @param Request $request
     */
    public function createEnv(Request $request)
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

        // Use Install Service to create env.
        $this->installService->createEnv($data);

        // Redirect to test db route.
        return redirect()->route('setup:test-db');
    }


    /**
     * Route to test if a successful database connection could be established. If not, the user gets returned back to the first entry screen.
     */
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

    /**
     * Route that migrates the database for the first time and displays the successful database connection.
     */
    public function success()
    {
        // Setup database and capture output
        $output = $this->installService->setupDatabase();

        return view('setup.success', [
            'output' => $output
        ]);
    }

    /**
     * POST request route to create the initial admin account.
     *
     * @param Request $request
     * @return void
     */
    public function createAdminAccount(Request $request)
    {
        // Validate admin details
        $validatedData = $request->validate([
            'admin_name'     => 'required|string',
            'admin_username' => 'required|string',
            'admin_email'    => 'required|email',
            'admin_password' => 'required|string'
        ]);

        // Create admin account and finish installation.
        $this->installService->createAdminAccount($validatedData);
        $this->installService->finishInstallation();

        // Setup complete! Redirect to admin login.
        return redirect()->route('admin:index');
    }
}
