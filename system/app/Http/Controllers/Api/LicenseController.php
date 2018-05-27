<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
