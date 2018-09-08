<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\Setup\UpdateService;

class UpdateController extends Controller
{
    protected $updateService;

    public function __construct(UpdateService $updateService)
    {
        $this->updateService = $updateService;

        $this->middleware('needs-update');
    }

    /**
     * The update view, where the user has to enter the UPDATE_PASSWORD to perform the update.
     * Only possible if the installed version is different from the one in the source file.
     */
    public function index()
    {
        return response()->view('setup.update.update');
    }

    /**
     * Route to perform the update by validating the update password and running the update from the UpdateService.
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        $updatePassword = env('UPDATE_PASSWORD', null);

        if ($updatePassword === null || $request->input('password') !== $updatePassword) {
            // abort(401, 'Incorrect Password');
            return response()->view('setup.update.update', ['error' => 'Incorrect Password']);
        }

        $output = $this->updateService->update();

        $this->updateService->updateVersionFile();

        $output .= PHP_EOL . 'Updated to new version: ' . config('app.version');

        return response()->view('setup.update.success', ['output' => $output]);
    }
}
