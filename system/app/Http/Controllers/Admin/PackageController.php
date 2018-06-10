<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Service\LicenseVerification;
use App\Package;

class PackageController extends Controller
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

    public function all()
    {
        $packages = Package::all();

        return response()->json($packages);
    }

    public function updateEnvatoItemId(Request $request, Package $package)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|gte:0'
        ]);

        $package->envato_item_id = $validatedData['id'];
        $package->save();

        return response(200);
    }

    public function testLicense(Request $request, Package $package)
    {
        $validatedData = $request->validate([
            'license' => 'required|string|max:512'
        ]);

        try {
            $this->licenseVerification->verifyOrFail(
                $validatedData['license'],
                $package,
                'admin',
                null
            );

            return response()->json([
                'valid' => true
            ]);
        } catch (\Exception $e) {
            throw $e;
            return response()->json([
                'valid' => false
            ]);
        }
    }
}
