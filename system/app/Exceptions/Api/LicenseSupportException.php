<?php

namespace App\Exceptions\Api;

class LicenseSupportException extends ApiException
{
    /**
	 * The error message that will be shown to the user, when the error is being handled.
	 * @var string
	 */
	protected $message = 'The support period for the supplied license has ended.';
	
	/**
	 * The http status code that will be shown to the user, when the error is being handled.
	 * @var string
	 */
	protected $code    = 403;
}
