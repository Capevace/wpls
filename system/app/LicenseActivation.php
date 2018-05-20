<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LicenseActivation extends Model
{
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['license_id', 'package_id', 'site_id'];
    
	// Our Primary Keys are UUIDs, not ints
	public $incrementing = false;
	public $keyType      = 'string';
	
	/**
	 * Get the license used in this activation.
	 * @return App\License
	 */
    public function license()
    {
    	return $this->belongsTo('App\License');
    }


    /**
     * Get the package that was activated with the license.
     * @return App\Package
     */
    public function package()
    {
    	return $this->belongsTo('App\Package');
    }


    /**
     * Get the site that was activated.
     * @return App\Site
     */
    public function site()
    {
    	return $this->belongsTo('App\Site');
    }
}
