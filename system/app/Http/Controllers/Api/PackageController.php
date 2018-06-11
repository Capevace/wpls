<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
			$metadata['download_url'] = route('package.download', [
				'package'    => $package,
				'activation' => ActivationGuard::getActivationIdForRequest()
			]);
		}

    	return response()->json($metadata);
	}
	
	public function download(Package $package)
	{
		// header('Content-Type: application/zip');
		// header('Content-Disposition: attachment; filename="' . $package->slug . '.zip"');
		// header('Content-Transfer-Encoding: binary');
		// header('Content-Length: ' . $package->getFileSize());

		return response()->download($package->storagePath(), $package->fileName()); /*[
			'Content-Type' => 'application/zip',
			'Content-Disposition' => 'attachment; filename="' . $package->slug . '.zip"'
		]*/
	}
}
