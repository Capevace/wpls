<?php

namespace App\Models;

use Storage;

class Package extends UuidBaseModel
{   
    /**
     * Model Fields:
     * - slug
     * - name
     * - version
     * - envato_item_id
     * - is_purcahse_code
     * - type
     * - last_metadata
     */
    

	// Our Primary Keys are UUIDs, not ints
	public $incrementing = false;
	public $keyType      = 'string';
    
    
	/**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'last_metadata' => 'array',
        'envato_item_id' => 'int',
    ];


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }


    /**
	 * Get all activations this package was used in.
	 * @return array
	 */
    public function activations()
    {
    	return $this->hasMany('App\Models\LicenseActivation');
    }

    /**
	 * Get all licenses this package was used in.
	 * @return array
	 */
    public function licenses()
    {
    	return $this->hasMany('App\Models\License');
    }

    /**
     * Get the path to the plugins zip file.
     *
     * @return string
     */
    public function storagePath()
    {
        return Storage::disk('packages')->path($this->fileName());
    }

    /**
     * Get the path to the plugins zip filename.
     *
     * @return string
     */
    public function fileName()
    {
        return sprintf('%s.zip', $this->slug);
    }
}
