<?php

namespace App\Exceptions;

class LicenseUnavailableException extends ApiException
{
    /**
	 * The error message that will be shown to the user, when the error is being handled.
	 * @var string
	 */
	protected $message = 'The limit for the amount of sites the theme/plugin can be enabled on has been reached.';
	
	/**
	 * The http status code that will be shown to the user, when the error is being handled.
	 * @var string
	 */
	protected $code    = 403;
}
