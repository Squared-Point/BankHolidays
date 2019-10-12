<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays;

use SquaredPoint\BankHolidays\Exception\JsonDecodeException;

class BankHolidayJsonBuilder
{

	public function __construct(string $bankHolidayDescriptor)
	{
		$bankHolidayArray = $this->jsonDecode($bankHolidayDescriptor);
	}

	private function jsonDecode(string $bankHolidayDescriptor) : array
	{
		$result = json_decode($bankHolidayDescriptor, true);
		if(json_last_error() === JSON_ERROR_NONE)
		{
			return $result;
		}

		switch (json_last_error()) {	
			case JSON_ERROR_NONE:	    
			break;
		    case JSON_ERROR_DEPTH:
		        $error = 'Maximum stack depth exceeded';
		    break;
		    case JSON_ERROR_STATE_MISMATCH:
		        $error = 'Underflow or the modes mismatch';
		    break;
		    case JSON_ERROR_CTRL_CHAR:
		        $error = 'Unexpected control character found';
		    break;
		    case JSON_ERROR_SYNTAX:
		        $error = 'Syntax error, malformed JSON';
		    break;
		    case JSON_ERROR_UTF8:
		        $error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
		    break;
		    default:
		        $error = 'Unknown error';
		    break;
		}

		throw new JsonDecodeException($error);
	}
}
