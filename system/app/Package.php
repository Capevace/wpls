<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
	use Uuids;
	
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
    	return $this->hasMany('App\LicenseActivation');
    }
}
