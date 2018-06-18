<?php

namespace App\Models;

class License extends UuidBaseModel
{   
    /**
     * Model Fields:
     * - license_key
     * - supported_until
     * - customer_data
     * - is_purchase_code
     */


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
    	return $this->hasMany('App\Models\LicenseActivation');
    }


    /**
     * Get all sites the license was used on.
     * @return Collection<App\Models\Site>
     */
    public function sites()
    {
        return $this->belongsToMany('App\Models\Site')->withTimestamps();
    }

    /**
     * Get the package the license was used for.
     *
     * @return App\Models\Package
     */
    public function package()
    {
        return $this->belongsTo('App\Models\Package');
    }
}
