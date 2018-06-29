<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\UpdateService;

class UpdateController extends Controller
{
    protected $updateService;

    public function __construct(UpdateService $updateService)
    {
        $this->updateService = $updateService;
    }

    public function index()
    {
        return response()->view('setup.update');
    }

    public function update(Request $request)
    {
        $updatePassword = env('UPDATE_PASSWORD', null);

        if ($updatePassword === null || $request->input('password') !== $updatePassword) {
            // abort(401, 'Incorrect Password');
            return response()->view('setup.update', ['error' => 'Incorrect Password']);
        }

        $output = $this->updateService->update();

        return response()->view('setup.success', ['output' => $output]);
    }
}
