<?php

namespace App\Models;

class Announcement extends UuidBaseModel
{
    /**
     * The available types an Announcement can have.
     *
     * @var array
     */
    public static $availableTypes = ['default', 'info', 'success', 'warning', 'error'];
    
    /**
     * Get the package the announcement was meant for.
     *
     * @return App\Models\Package
     */
    public function packages()
    {
        return $this->belongsToMany('App\Models\Package');
    }
}
