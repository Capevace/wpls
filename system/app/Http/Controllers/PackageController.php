<?php

namespace App\Http\Controllers;

use App\Facades\ActivationGuard;
use App\Package;
use App\Service\PackageParser;
use Illuminate\Http\Request;

class PackageController extends Controller
{
	protected $licenseVerification;
	protected $packageParser;

	public function __construct(PackageParser $packageParser)
	{
		$this->packageParser = $packageParser;
	}

    public function get(Request $request, Package $package)
    {
    	return response()->json($this->packageParser->parsePackageMetadata($package));
    }

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
			$metadata['download_url'] = 'http://google.com';
		}

    	return response()->json($metadata);
    }
}
