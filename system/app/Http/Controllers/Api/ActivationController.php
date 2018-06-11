<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\LicenseActivation;
use App\Exceptions\Api\LicenseUnavailableException;
use App\Service\LicenseStateService;
use App\Service\LicenseVerification;
use App\Http\Requests\LicenseActivationRequest;
use App\Http\Requests\LicenseDeactivationRequest;

class ActivationController extends Controller
{
	/**
     * The license verification instance.
     */
    protected $licenseVerification;

    /**
     * The license state service instance.
     */
    protected $licenseStateService;

    /**
     * Create a new controller instance.
     *
     * @param App\Service\LicenseVerification $licenseVerification
     * @param App\Service\LicenseStateService $licenseStateService
     * @return void
     */
    public function __construct(LicenseVerification $licenseVerification, LicenseStateService $licenseStateService)
    {
        $this->licenseVerification = $licenseVerification;
        $this->licenseStateService = $licenseStateService;
    }

	/**
	 * Handle an activation request.
     * 
     * This will create a LicenseActivation for the given license and package.
     * It will also link that to the site given.
     * 
     * @param LicenseActivationRequest $request 
	 * @return \Illuminate\Http\Response
	 */
    public function activate(LicenseActivationRequest $request)
    {
    	$validatedData = $request->validated();
    	
        // Verify given license data.
        $verificationResult = $this->licenseVerification->verifyOrFail(
            $validatedData['license'],
            $validatedData['slug'],
            $validatedData['site'],
            json_decode($validatedData['site-meta'])
        );

        // Activate a license and check, if it was activated before
        $activationResult = $this->licenseStateService->activateOrFail(
            $verificationResult['license'],
            $verificationResult['package'],
            $verificationResult['site'],
            $verificationResult['siteMeta']
        );

        // Determine activation result
        $wasActivatedBefore = (bool) $activationResult['wasActivated'];
        $activation         = $activationResult['activation'];

        // Determine response message given the result of the usage check.
        $message = $wasActivatedBefore
            ? 'The plugin was already activated for this site.'
            : 'The plugin was successfully activated.';

        return response()->json([
            'activated'  => true,
            'activation_id' => $activation->id,
            'message'    => $message
        ]);
    }

    /**
     * Handle a deactivation request.
     * 
     * This will delete a LicenseActivation for the given license, package and site, if found.
     * 
     * @param LicenseActivationRequest $request 
     * @return \Illuminate\Http\Response
     */
    public function deactivate(LicenseDeactivationRequest $request)
    {
        $validatedData = $request->validated();
        
        // Verify given license data.
        $verificationResult = $this->licenseVerification->verifyOrFail(
            $validatedData['license'],
            $validatedData['slug'],
            $validatedData['site'],
            json_decode($validatedData['site-meta'])
        );

        // Activate a license and check, if it was activated before
        $this->licenseStateService->deactivateOrFail(
            $verificationResult['license'],
            $verificationResult['package'],
            $verificationResult['site'],
            $verificationResult['siteMeta']
        );

        return response()->json([
            'deactivated' => true,
            'message'     => 'The license was successfully deactivated.',
        ]);
    }

    /**
     * Handle a deactivation request.
     * 
     * This will delete a given LicenseActivation.
     * 
     * @param LicenseActivation $activation 
     * @return \Illuminate\Http\Response
     */
    public function deactivateActivation(LicenseActivation $activation)
    {
        $activation->delete();

        return response()->json([
            'deactivated' => true,
            'message'     => 'The license was successfully deactivated.',
        ]);
    }
}
