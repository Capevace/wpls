<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use Uuids;
    
    /**
     * Model Fields:
     * - license_key
     * - supported_until
     * - customer_data
     * - is_purchase_code
     */

	
	// Our Primary Keys are UUIDs, not ints
	public $incrementing = false;
	public $keyType      = 'string';


	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'supported_until',
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'license_key',
        'package_id',
        'supported_until',
        'customer_data',
        'is_purchase_code',
        'max_activations',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'customer_data' => 'array',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'license_key';
    }


	/**
	 * Get all activations this license was used in.
	 * @return array
	 */
    public function activations()
    {
    	return $this->hasMany('App\LicenseActivation');
    }


    /**
     * Get all sites the license was used on.
     * @return Collection<App\Site>
     */
    public function sites()
    {
        return $this->belongsToMany('App\Site')->withTimestamps();
    }

    /**
     * Get the package the license was used for.
     *
     * @return App\Package
     */
    public function package()
    {
        return $this->belongsTo('App\Package');
    }
}
