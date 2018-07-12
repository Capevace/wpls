<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Facades\ActivationGuard;
use App\Models\Package;
use App\Service\PackageParser;
use Illuminate\Http\Request;

class PackageController extends Controller
{
	protected $licenseVerification;
	protected $packageParser;

	/**
	 * Construct a new PackageController instance.
	 *
	 * @param PackageParser $packageParser
	 */
	public function __construct(PackageParser $packageParser)
	{
		$this->packageParser = $packageParser;
	}

	/**
	 * Handles a metadata request.
	 * 
	 * This returns metadata for a given package and adds a 
	 * download link to it if its authenticated by an activated License.
	 *
	 * @param Request $request
	 * @param Package $package
	 * @return Illuminate\Http\Response
	 */
    public function getMetadata(Request $request, Package $package)
    {
    	$licenseKey = $request->query('license');
    	$site       = $request->query('site');
    	$siteMeta   = $request->query('site-meta');

    	// $this->licenseVerification->findLicenseOrFail($licenseKey, );
		$metadata = $this->packageParser->parsePackageMetadata($package);
		// $metadata = $package->last_metadata;
		
		// If there was an activation passed, add download url to metadata.
		if (ActivationGuard::check()) {
			$metadata['download_url'] = route('package:download', [
				'package'    => $package,
				'activation' => ActivationGuard::getActivationIdForRequest()
			]);
		}

    	return response()->json($metadata);
	}
	
	/**
	 * Handles a download request for a given Package.
	 *
	 * @param Package $package
	 * @return Illuminate\Http\Response
	 */
	public function download(Package $package)
	{
		if (ActivationGuard::check()) {
			return response()->download($package->storagePath(), $package->fileName());
		}
		
		return response(null, 401);
	}
}
