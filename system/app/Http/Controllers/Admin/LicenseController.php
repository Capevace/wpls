<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Exceptions\Api\LicenseAlreadyExistsException;
use App\Service\LicenseVerification;
use App\License;
use App\Package;
use Carbon\Carbon;

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

    /**
     * Get all Licenses, filter them by a limit or a search string and return them as json.
     *
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $limit  = $request->query('limit', 100);
        $search = $request->query('search', '');

        if ($search === '') {
            $licenses = License::take($limit);
        } else {
            $licenses = License::where('license_key', 'like', '%' . $search . '%')->take($limit);
        }

        $licenses = $licenses
            ->join('packages', 'licenses.package_id', '=', 'packages.id')
            ->select('licenses.*', 'packages.slug as package_slug')
            ->orderBy('licenses.created_at', 'DESC')
            ->get();

        return response()->json($licenses);
    }

    /**
     * Issues a new License for a given package and return it as json.
     *
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'slug' => 'required|max:255',
            'license' => 'required|max:512',
            'supportedUntil' => 'required|date',
            'customerInfo' => 'required|array',
            'maxActivations' => 'integer|min:1'
        ]);

        $package = Package::where('slug', '=', $validatedData['slug'])
            ->firstOrFail();
        
        $previousLicense = License::where('package_id', '=', $package->id)
            ->where('license_key', '=', $validatedData['license'])
            ->first();

        if ($previousLicense) {
            throw new LicenseAlreadyExistsException;
        }

        $license                   = new License;
        $license->license_key      = $validatedData['license'];
        $license->supported_until  = $validatedData['supportedUntil'];
        $license->customer_data    = $validatedData['customerInfo'];
        $license->is_purchase_code = false;

        if (array_key_exists('maxActivations', $validatedData)) {
            $license->max_activations = $validatedData['maxActivations'];
        }

        $license->package()->associate($package);
        $license->save();

        return response()->json($license);
    }

    /**
     * Invalidates a License by setting its supporting date back in time.
     *
     * @param Request $request
     * @param License $license
     * @return Illuminate\Http\Response
     */
    public function invalidate(Request $request, License $license)
    {
        $license->supported_until = Carbon::yesterday();
        $license->save();

        return response(200);
    }

    /**
     * Deletes a License from the Database.
     *
     * @param Request $request
     * @param License $license
     * @return Illuminate\Http\Response
     */
    public function delete(Request $request, License $license)
    {
        $license->delete();

        return response(200);
    }
}
