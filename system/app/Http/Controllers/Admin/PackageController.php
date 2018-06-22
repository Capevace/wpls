<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Service\LicenseVerification;
use App\Service\PackageParser;
use App\Models\Package;
use Storage;

class PackageController extends Controller
{
    /**
     * The license verification instance.
     */
    protected $licenseVerification;

    protected $packageParser;

    /**
     * Create a new controller instance.
     *
     * @param  LicenseVerification $licenseVerification
     * @return void
     */
    public function __construct(LicenseVerification $licenseVerification, PackageParser $packageParser)
    {
        $this->licenseVerification = $licenseVerification;
        $this->packageParser       = $packageParser;
    }

    /**
     * Get all packages as json.
     *
     * @return void
     */
    public function all()
    {
        $packages = Package::all();

        return response()->json($packages);
    }

    public function get(Package $package)
    {
        $activationsCount = $package->activations()->count();
        $licensesCount    = $package->licenses()->count();

        return response()->json([
            'package'           => $package,
            'licenses_count'    => $licensesCount,
            'activations_count' => $activationsCount
        ]);
    }

    /**
     * Create a new package and save the package zip file in storage.
     *
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'slug' => 'required|string|max:256',
            'package' => 'required|file|mimes:zip'
        ]);

        $packageFile = $validatedData['package'];
        $path = Storage::disk('packages')->putFileAs(
            '',
            $packageFile, 
            sprintf('%s.zip', $validatedData['slug'])
        );

        $package = new Package;
        $package->slug = $validatedData['slug'];

        $metadata = $this->packageParser->parsePackageMetadata($package);
        
        $package->name = $metadata['name'];
        $package->version = $metadata['version'];
        $package->last_metadata = $metadata;
        $package->save();

        return response(200);
    }

    /**
     * Update the Envato Item ID for a given package.
     *
     * @param Request $request
     * @param Package $package
     * @return Illuminate\Http\Response
     */
    public function updateEnvatoItemId(Request $request, Package $package)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|gte:0'
        ]);

        $package->envato_item_id = $validatedData['id'];
        $package->save();

        return response(200);
    }

    /**
     * Test a License on a Package to see if it's valid.
     *
     * @param Request $request
     * @param Package $package
     * @return Illuminate\Http\Response
     */
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
        }
    }

    /**
     * Delete a given Package and remove its files.
     *
     * @param Package $package
     * @return Illuminate\Http\Response
     */
    public function delete(Package $package)
    {
        // Delete Package files
        Storage::disk('packages')->delete($package->fileName());
        $package->delete();

        return response(200);
    }

    /**
     * Issue an update to the packages files and replace the old one.
     *
     * @param Request $request
     * @param Package $package
     * @return void
     */
    public function update(Request $request, Package $package)
    {
        $validatedData = $request->validate([
            'package' => 'required|file|mimes:zip'
        ]);

        // Delete old file
        Storage::disk('packages')->delete($package->fileName());

        $packageFile = $validatedData['package'];
        $path = Storage::disk('packages')->putFileAs(
            '',
            $packageFile, 
            $package->fileName()
        );

        $metadata = $this->packageParser->parsePackageMetadata($package);
        
        $package->name = $metadata['name'];
        $package->version = $metadata['version'];
        $package->last_metadata = $metadata;
        $package->save();

        return response(200);
    }
}
