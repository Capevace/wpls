<?php

namespace App\Models;

class LicenseActivation extends UuidBaseModel
{
	/**
	 * Get the license used in this activation.
	 * @return App\Models\License
	 */
    public function license()
    {
    	return $this->belongsTo('App\Models\License');
    }

    /**
     * Get the package that was activated with the license.
     * @return App\Models\Package
     */
    public function package()
    {
    	return $this->belongsTo('App\Models\Package');
    }

    /**
     * Get the site that was activated.
     * @return App\Models\Site
     */
    public function site()
    {
    	return $this->belongsTo('App\Models\Site');
    }
}
