<?php

namespace App\Facades;

use \Illuminate\Support\Facades\Facade;

class ActivationGuard extends Facade {
    protected static function getFacadeAccessor() { return 'ActivationGuard'; }
}