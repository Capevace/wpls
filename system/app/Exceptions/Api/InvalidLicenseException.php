<?php

namespace App\Exceptions\Api;

class InvalidLicenseException extends ApiException
{
    /**
	 * The error message that will be shown to the user, when the error is being handled.
	 * @var string
	 */
	protected $message = 'The supplied license is invalid.';
	
	/**
	 * The http status code that will be shown to the user, when the error is being handled.
	 * @var string
	 */
	protected $code    = 403;
}
