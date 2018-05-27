<?php

namespace App\Api\Exceptions;

class EnvatoConnectionException extends ApiException
{
    /**
	 * The error message that will be shown to the user, when the error is being handled.
	 * @var string
	 */
	protected $message = 'An unknown error occurred while trying to reach Envato\'s servers.';
	
	/**
	 * The http status code that will be shown to the user, when the error is being handled.
	 * @var string
	 */
	protected $code    = 500;
}
