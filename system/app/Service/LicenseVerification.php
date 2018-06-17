<?php

namespace App\Service;

use App\License;
use App\Package;
use App\Site;

use App\Exceptions\Api\LicenseSupportException;
use App\Exceptions\Api\EnvatoConnectionException;
use App\Exceptions\Api\InvalidLicenseException;
use App\Exceptions\Api\UnknownPackageException;

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as HTTPClient;

class LicenseVerification
{
    const ENVATO_API_URL = 'https://api.envato.com/v3/market/author/sale?code=';
	
    /**
     * Get and verify a license with the given data (license and slug).
     * @param string $licenseKey The license key.
     * @param string|App\Package $packageOrSlug The package or its slug.
     * @return App\License
     * 
     * @throws App\Exceptions\LicenseSupportException
     * @throws App\Exceptions\EnvatoConnectionException
     * @throws App\Exceptions\InvalidLicenseException
     * @throws App\Exceptions\UnknownPackageException
     */
    public function verifyOrFail(string $licenseKey, $packageOrSlug, string $siteUrl, $siteMeta = null)
    {
    	// 1. Check if a license exists in the database (?RETURN true)
    	// 2. If it doesn't, that still doesn't mean the license is invalid. It may be an unused Envato purchase code.
    	// 3. Query the Envato Api for the purchase code.
    	// 4. If that purchase is valid, save it in the database. (?RETURN TRUE)
    	// RETURN false

        if ($packageOrSlug instanceof Package) {
            $package = $packageOrSlug;
        } else {
            $package = $this->getPackage($packageOrSlug);
        }

        $license = $this->findLicense($licenseKey, $package);

        if ($license === null)
            $license = $this->checkEnvato($licenseKey, $package);

        $site = $this->getOrCreateSite($siteUrl, $siteMeta);

        return [
            'license'  => $license,
            'package'  => $package,
            'site'     => $site,
            'siteMeta' => $siteMeta
        ];
    }


    /**
     * Gets the referenced package from the database.
     * @param string $slug 
     * @return App\Package
     */
    protected function getPackage($slug)
    {
        // Get package with slug
        $package = Package::where('slug', $slug)->first();

        // If no package with that envato id exists, its unknown.
        if ($package === null) {
            throw new UnknownPackageException;
        }

        return $package;
    }

    /**
     * Check if a License with the given data was already registered in the database.
     * @param string $licenseKey 
     * @param App\Package $package
     * @return null|App\License
     * 
     * @throws App\Exceptions\LicenseSupportException
     */
    protected function findLicense($licenseKey, $package)
    {
        // Find License with key and slug
        $license = License::where('license_key', $licenseKey)
            ->where('package_id', $package->id)
            ->first();

        // If License was found, check if its still supported otherwise throw.
        if ($license !== null) {
            if (strtotime($license->supported_until) < time()) {
                throw new LicenseSupportException();
            } else {
                return $license;
            }
        }

        return null;
    }


    /**
     * Validate a license (purchase code) with Envatos servers.
     * @param array $data 
     * @param App\Package $package
     * @return null|App\License
     * 
     * @throws App\Exceptions\LicenseSupportException
     * @throws App\Exceptions\EnvatoConnectionException
     * @throws App\Exceptions\InvalidLicenseException
     * @throws App\Exceptions\UnknownPackageException
     */
    protected function checkEnvato($licenseKey, $package)
    {
        // Make & send HTTP request to envato servers
        $client   = new HTTPClient([
            'http_errors' => false,
            'headers'     => [
                'Authorization' => 'Bearer ' . env('ENVATO_API_KEY')
            ]
        ]);

        $response     = $client->request('GET', static::ENVATO_API_URL . $licenseKey);
        $body         = (string) $response->getBody();
        $responseData = json_decode($body);

        // If response is Unauthorized something is wrong with our connection to envato. Most likely the API key.
        if ($response->getStatusCode() === 401) {
            throw new EnvatoConnectionException();
        }

        // If the response contains an 'error' field, something is wrong with the license.
        if (property_exists($responseData, 'error')) {
            throw new InvalidLicenseException();
        }

        // Fetch the package with the given envato item id.
        $envatoItemId = $responseData->item->id;

        // if a package is found, but the envato id of the one found and the one requested don't match, the license is invalid.
        if ($package->envato_item_id !== $envatoItemId) {
            throw new InvalidLicenseException();
        }

        // If the supported time for the purchase code is over, throw.
        if (strtotime($responseData->supported_until) < time()) {
            throw new LicenseSupportException();
        }

        // Create new License and save it in the database.
        $license = License::create([
            'license_key'      => $licenseKey,
            'package_id'       => $package->id,
            'supported_until'  => Carbon::parse($responseData->supported_until), // So we have the same date format everywhere
            'customer_data'    => [],
            'is_purchase_code' => true,
            'max_activations'  => 1
        ]);

        return $license;
    }

    /**
     * This methods checks if a site with a given url exists, fetches it or creates a new one.
     * @param string $siteUrl 
     * @param stdObject $siteMeta
     * @return App\Site
     */
    public function getOrCreateSite($siteUrl, $siteMeta)
    {
        $site = Site::where('url', $siteUrl)->first();

        if ($site === null) {
            $site = new Site;
            $site->url = $siteUrl;
            $site->checkAndSetMetadata($siteMeta);

            // Site should not get saved just yet. We dont need to save it, if it cant be activated.
            // $site->save();
        }

        return $site;
    }
}
