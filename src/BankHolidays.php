<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays;

use SquaredPoint\BankHolidays\Value\DateRange;
use SquaredPoint\BankHolidays\Exception\InvalidDateRangeException;

class BankHolidays
{
	private $bankHolidays = [];
	private $dayRange;

	/**
	* @var $range DateRange
	* @var $bankHolidays \DateTime[] or string[]
	*/
	public function __construct(DateRange $range, array $bankHolidays)
	{				
	}

	public function isBankHoliday($date) : bool
	{
		return false;
	}
}
