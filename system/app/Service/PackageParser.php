<?php

namespace App\Service;

use App\Models\Package;
use Storage;
use Exception;
use WPPackageParser\Parser;

class PackageParser 
{
	/**
	 * Parse the metadata from the package files for a given package and return it in a structured way.
	 * 
	 * This function will lookup the zip file for a package and read the metadata from that.
	 *
	 * @param Package $package
	 * @return object
	 */
	public function parsePackageMetadata(Package $package)
	{
		$packageZipFilePath = $package->storagePath();
		$parsedMetadata     = Parser::parse($packageZipFilePath, true);

		if ($parsedMetadata === false) {
			throw new Exception(sprintf('The Package archive file "%s" could not be parsed for metadata.', $packageZipFilePath));
		}

		$isPlugin = $parsedMetadata['type'] === 'plugin';
		$header   = $parsedMetadata['header'];
		$readme   = $parsedMetadata['readme'];

		if (!array_key_exists('Version', $header)) {
			throw new Exception('The Package metadata did not supply a package version. This is required.');
		}

		if (!array_key_exists('Name', $header)) {
			throw new Exception('The Package metadata did not supply a package name. This is required.');
		}

		$homepageUrl = $isPlugin ? $header['PluginURI'] : $header['ThemeURI']; // PluginURI/ThemeURI

		$metadata = [
			'name'            => $header['Name'],
			'slug'            => $package->slug,
			'version'         => $header['Version'],
			'homepage'        => $homepageUrl,
			'author'          => $header['Author'],
			'author_homepage' => $header['AuthorURI'],
			'details_url'     => isset($header['DetailsURI']) ?
									$header['DetailsURI']
									: $homepageUrl,
			// 'depends'         => '',
			// 'provides'        => '',
			'type'            => $parsedMetadata['type']
		];

		// Add relevant information from readme
		if (is_array($readme) && count($readme) > 0) {
			$metadata['requires'] = $readme['requires'];
			$metadata['tested']   = $readme['tested'];

			// Add sections (Installation, Screenshots etc)
			$sections             = $readme['sections'];
			$metadata['sections'] = [];
			if (is_array($sections) && count ($sections) > 0) {
				foreach($sections as $sectionName => $sectionContent) {
					// Key-ify section name
					$sectionName = str_replace(' ', '_', strtolower($sectionName));

					$metadata['sections'][$sectionName] = $sectionContent;
				}
			}

			// Parse upgrade notice
			if (isset($metadata['sections']['upgrade_notice'])) {
				$regex = '/^\= ' . preg_quote($header['Version']) . ' \=\\s?\\n(.*)\\n$/';

				$matches = null;
				if (preg_match($regex, $matches)) {
					$metadata['upgrade_notice'] = trim($matches[1]);
				}
			}

			// Add last updated timestamp
			$metadata['last_updated'] = gmdate('Y-m-d H:i:s', filemtime($packageZipFilePath));
		}


		return $metadata;
	}
}