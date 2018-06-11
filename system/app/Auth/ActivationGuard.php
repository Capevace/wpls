<?php

namespace App\Auth;

use App\LicenseActivation;
use App\Package;

use Illuminate\Http\Request;

class ActivationGuard
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The discovered license activation.
     *
     * @var App\LicenseActivation
     */
    protected $activation;

    /**
     * Create a new activation guard instance.
     *
     * @param Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Checks, if a request has been authenticated with a license activation id, which, in this case, acts as an access token.
     *
     * @param null|App\Package $package The package to check the activation against.
     * @return bool
     */
    public function check(Package $package = null)
    {
        return !is_null($this->activation($package));
    }

    /**
     * Get the current activation passed along with the request.
     *
     * @param null|App\Package $package The package to check the activation against.
     * @return App\LicenseActivation
     */
    public function activation(Package $package = null)
    {
        // If we've already retrieved the activation for the current request we can just
        // return it back immediately. We do not want to fetch the activation data on
        // every call to this method because that would be tremendously slow.
        if (!is_null($this->activation)) {
            return $this->activation;
        }
        $activationId = $this->getActivationIdForRequest();
        $packageId    = $this->getPackageIdForRequest($package);

        $activation = null;

        if (!empty($activationId) && !empty($packageId)) {
            $activation = LicenseActivation::find($activationId);

            if (is_null($activation)) {
                return null;
            }

            // Check if the activation is actually for this package.
            if ($activation->package_id !== $packageId) {
                return null;
            }
        }

        return $activation;
    }

    /**
     * Get the activation id for the current request.
     *
     * @return string
     */
    public function getActivationIdForRequest()
    {
        $inputKey = 'activation';

        $activationId = $this->request->bearerToken();

        if (empty($activationId)) {
            $activationId = $this->request->query($inputKey);
        }

        if (empty($activationId)) {
            $activationId = $this->request->input($inputKey);
        }

        return $activationId;
    }

    /**
     * Get the package id for the current request.
     *
     * @param null|App\Package $package
     * @return string
     */
    public function getPackageIdForRequest(Package $package = null)
    {
        // If a specific package was given, we just use that one instead of the one specified in a request.
        if (!is_null($package)) {
            return $package->id;
        }

        $package = $this->request->route('package');
        if (!empty($package)) {
            return $package->id;
        }

        $slug = null;

        if (empty($slug)) {
            $slug = $this->request->query('slug');
        }

        if (empty($slug)) {
            $slug = $this->request->input('slug');
        }

        if (!empty($slug)) {
            $package = Package::where('slug', $slug);

            if (!is_null($package)) {
                return $package->id;
            }
        }

        return null;
    }
}
