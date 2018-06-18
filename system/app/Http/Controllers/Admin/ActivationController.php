<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LicenseActivation;

use Carbon\Carbon;

class ActivationController extends Controller
{
    /**
     * Get all LicenseActivations, filter them by date and return them as json.
     *
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $validatedData = $request->validate([
            'from' => 'required|date',
            'to'   => 'required|date'
        ]);

    	$fromTime  = $validatedData['from'];
        $toTime    = $validatedData['to'];

        $licenses = LicenseActivation::where('license_activations.created_at', '>=', Carbon::parse($fromTime)->startOfDay())
            ->where('license_activations.created_at', '<=', Carbon::parse($toTime)->endOfDay())
            ->join('packages', 'license_activations.package_id', '=', 'packages.id')
            ->join('licenses', 'license_activations.license_id', '=', 'licenses.id')
            ->join('sites', 'license_activations.site_id', '=', 'sites.id')
            ->select(
                'license_activations.*', 
                'packages.slug as package_slug', 
                'licenses.license_key as license_key',
                'licenses.customer_data as license_customer_data',
                'sites.url as site_url',
                'sites.last_wp_version as site_last_wp_version',
                'sites.last_php_version as site_last_php_version',
                'sites.last_package_version as site_last_package_version'
            )
            ->get();

        return response()->json($licenses);
    }
}
