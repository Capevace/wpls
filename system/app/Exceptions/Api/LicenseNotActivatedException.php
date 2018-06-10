<?php

namespace App\Exceptions\Api;

class LicenseNotActivatedException extends ApiException
{
    /**
	 * The error message that will be shown to the user, when the error is being handled.
	 * @var string
	 */
	protected $message = 'The license you wanted to deactivate was never activated for that package or that site.';
	
	/**
	 * The http status code that will be shown to the user, when the error is being handled.
	 * @var string
	 */
	protected $code    = 404;
}
