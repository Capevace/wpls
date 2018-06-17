<?php

namespace App\Facades;

use \Illuminate\Support\Facades\Facade;

/**
 * @see App\Auth\ActivationGuard
 */
class ActivationGuard extends Facade {
    protected static function getFacadeAccessor() { return 'ActivationGuard'; }
}