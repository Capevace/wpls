<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LicenseController extends Controller
{
    /**
     * The license verification instance.
     */
    protected $licenseVerification;

    /**
     * Create a new controller instance.
     *
     * @param  LicenseVerification $licenseVerification
     * @return void
     */
    public function __construct(LicenseVerification $licenseVerification)
    {
        $this->licenseVerification = $licenseVerification;
    }

    public function get(Request $request)
    {
    	
    }
}
