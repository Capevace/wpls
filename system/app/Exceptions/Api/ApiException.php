<?php

namespace App\Exceptions\Api;

use Exception;

/**
 * The base Exception class for the api. Returns exception data in json format.
 */
class ApiException extends Exception
{
	/**
	 * The error message that will be shown to the user, when the error is being handled.
	 * @var string
	 */
	protected $message = 'An unknown error occurred.';
	
	/**
	 * The http status code that will be shown to the user, when the error is being handled.
	 * @var string
	 */
	protected $code    = 500;

    /**
     * Json data that will be included within the response.
     * @var array
     */
    protected $jsonData = [];

    /**
     * Add JSON to the exception output.
     * @param array $data 
     */
    public function setJsonData($data)
    {
        $this->jsonData = $data;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        /*return response()->view('error.general', [
        	'code'    => $this->code,
        	'message' => $this->message
        ], $this->code);*/
        return response()->json([
        	'error' => [
	        	'code'    => $this->code,
	        	'message' => $this->message
	        ],
            'message' => $this->message
        ], $this->code);
    }

    /**
     * Add JSON to the exception output.
     * @param array $data 
     */
    public static function withJson($data)
    {
        $exception = new static;
        $exception->setJsonData($data);

        return $exception;
    }
}
