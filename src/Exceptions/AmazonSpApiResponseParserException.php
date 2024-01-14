<?php

namespace EolabsIo\AmazonSpApiResponseParser\Exceptions;

use Exception;


class AmazonSpApiResponseParserException extends Exception
{
	public function __construct() {
		parent::__construct('The Amazon Response provided is not supported with this Parser');
	}
}
