<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays;

use SquaredPoint\BankHolidays\Value\BankHolidayAdmin;
use SquaredPoint\BankHolidays\Exception\JsonDecodeException;
use SquaredPoint\BankHolidays\Exception\BankHolidayFormatException;
use PASVL\Traverser\VO\Traverser;
use PASVL\ValidatorLocator\ValidatorLocator;

class BankHolidayJsonBuilder
{
	private $constraintBuilders;
	private $constraintsList;
	private $children;
	private $bankHolidayList;

	public function __construct(string $bankHolidayDescriptor)
	{
		$bankHolidayArray = $this->jsonDecode($bankHolidayDescriptor);		
		$this->validateBankHolidayFormat($bankHolidayArray);

		$holidayList = $bankHolidayArray["bank_holidays"];
		$options = $bankHolidayArray;
		unset($options["bank_holidays"]);

		$this->createBankHolidayAdmin($holidayList, $options);
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

	public function createBankHolidayAdmin($holidayList, $rawOptions) : BankHolidayAdmin
	{
		$options = [];
		if(array_key_exists("name", $rawOptions))
		{
			$options["name"] = $rawOptions["name"];
		}

		return new BankHolidayAdmin($holidayList, $options);
	}

	// https://lessthan12ms.com/how-to-validate-a-php-array-format-structure/
	private function validateBankHolidayFormat($bankHolidayArray)
	{
		$pattern = [
		    "bank_holidays" => ["*" => ":string :date"],
		    "name?" => ":string"
		];

		$traverser = new Traverser(new ValidatorLocator());

		 if(! $traverser->check($pattern, $bankHolidayArray))
		 {
		 	throw new BankHolidayFormatException("Incorrect input format", 1);
		 }
	}
}
