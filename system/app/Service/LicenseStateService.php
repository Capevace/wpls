<?php

namespace App\Service;

use App\License;
use App\Package;
use App\Site;
use App\LicenseActivation;

use App\Exceptions\Api\LicenseUnavailableException;
use App\Exceptions\Api\LicenseNotActivatedException;

/**
 * The class that handles activating and deactivating of licenses.
 */
class LicenseStateService
{
	/**
	 * This method activates a license and resaves new site metadata if given.
	 * 
	 * The license for the given package will be activated and linked to the given site.
	 * The metadata will be used to track WordPress usage etc...
	 * 
	 * It returns an array containing information 
	 * wether the license was activated previously for that site, and the LicenseActivation object.
	 * 
	 * @param App\License $license 
	 * @param App\Package $package 
	 * @param App\Site $site 
	 * @param object $siteMeta 
	 * @return array ['wasActivated' => true|false, 'activation' => LicenseActivation] 
	 */
	public function activateOrFail(License $license, Package $package, Site $site, $siteMeta)
	{
		// Check if there the license has been activated before
        $previousActivations = LicenseActivation::where('license_id', $license->id)
            ->where('package_id', $package->id)
            ->get();

        $previousActivation = $previousActivations->where('site_id', $site->id)->first();

        // If the site requesting activation was activated before, just return true anyway.
        if ($previousActivation !== null) {
            $site->checkAndSetMetadata($siteMeta);
            $site->save();
            
            return [
                'wasActivated' => true,
                'activation'   => $previousActivation
            ];
        }

        // If the available License activations count has been depleted, throw exception
        if ($previousActivations->count() >= $license->max_activations) {
            throw new LicenseUnavailableException;
        }

        // We can save the site now because we know it will be activated.
        // We also set the metadata to update it if it was given
        $site->checkAndSetMetadata($siteMeta);
        $site->save();

        $activation = new LicenseActivation([
            'license_id' => $license->id,
            'package_id' => $package->id,
            'site_id'    => $site->id,
        ]);
        $activation->save();

        return [
        	'wasActivated' => false,
        	'activation'   => $activation
        ];
	}


    /**
     * Deactivate a license for a package, linked to a site.
     * 
     * @param App\License $license 
     * @param App\Package $package 
     * @param App\Site $site 
     * @param object $siteMeta 
     * @return void
     */
    public function deactivateOrFail(License $license, Package $package, Site $site, $siteMeta)
    {
        $activation = LicenseActivation::where('license_id', $license->id)
            ->where('package_id', $package->id)
            ->where('site_id', $site->id)
            ->first();

        if ($activation === null) {
            throw new LicenseNotActivatedException;
        }

        $activation->delete();
    }
}