<?php

namespace App\Exceptions\Searcher;

use App\Exceptions\Searcher\SearchExceptionInterface;
use \Exception;

class SearchException extends \Exception implements SearchExceptionInterface
{
    const DEFAULTCODE = 99999;
	
	public function __construct($message, $code = self::DEFAULTCODE, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public static $errors = array(
        'HTTP_STATUS' => array('code' => 403, 'message' => ' api result is not availble this point in time')
    );

    
}