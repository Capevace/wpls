<?php

namespace App\Service;

use App\Package;

use Storage;

use WPPackageParser\Parser;

class PackageParser 
{
	public function parsePackageMetadata(Package $package)
	{
		$filePath = sprintf('%s/%s.zip', $package->slug, $package->slug);

		$packageZipFilePath = Storage::disk('packages')->path($filePath);
		$parsedMetadata = Parser::parse($packageZipFilePath);

		if ($parsedMetadata === false)
			throw new Exception();

		$isPlugin = $parsedMetadata['type'] === 'plugin';
		$header = $parsedMetadata['header'];
		$readme = $parsedMetadata['readme'];

		if ($header['Version']) {
			//throw Version required
		}

		$metadata = [
			'name'            => $header['Name'],
			'slug'            => $package->slug,
			'version'         => $header['Version'],
			'homepage'        => $isPlugin ? $header['PluginURI'] : $header['ThemeURI'], // PluginURI/ThemeURI
			'author'          => $header['Author'],
			'author_homepage' => $header['AuthorURI'],
			'details_url'     => isset($header['DetailsURI']) ?
									$header['DetailsURI']
									: $isPlugin ? $header['PluginURI'] : $header['ThemeURI'],
			'depends'         => '',
			'provides'        => '',
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