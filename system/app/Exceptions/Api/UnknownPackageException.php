<?php

namespace App\Api\Exceptions;

class UnknownPackageException extends ApiException
{
	/**
	 * The error message that will be shown to the user, when the error is being handled.
	 * @var string
	 */
	protected $message = 'The theme/plugin with was not found.';
	
	/**
	 * The http status code that will be shown to the user, when the error is being handled.
	 * @var string
	 */
	protected $code    = 404;
}
