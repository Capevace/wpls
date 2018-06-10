<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use Uuids;

    /**
     * Model Fields:
     * - url
     * - last_wp_version
     * - last_php_version
     * - last_package_version
     */


	// Our Primary Keys are UUIDs, not ints
	public $incrementing = false;
	public $keyType      = 'string';


    /**
	 * Get all activations this site was used in.
	 * @return array
	 */
    public function activations()
    {
    	return $this->hasMany('App\LicenseActivation');
    }


    /**
	 * Get all licenses this site was used in.
	 * @return array
	 */
    public function licenses()
    {
    	return $this->belongsToMany('App\License')->withTimestamps();
    }


    /**
     * Checks if metadata is given and sets it accordingly.
     * @param stdClass $metadata
     */
    public function checkAndSetMetadata($metadata)
    {
        if (is_null($metadata) || !\is_object($metadata))
            return;
            
    	if (property_exists($metadata, 'wp_version'))
            $this->last_wp_version = $metadata->wp_version;

        if (property_exists($metadata, 'php_version'))
            $this->last_php_version = $metadata->php_version;

        if (property_exists($metadata, 'package_version'))
            $this->last_package_version = $metadata->package_version;
    }
}
