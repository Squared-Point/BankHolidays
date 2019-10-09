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
		$this->dayRange = $range;
		foreach($bankHolidays as $bankHoliday)
		{
			$this->add($bankHoliday);
		}
	}

	private function add($bankHoliday)
	{
		if($this->isBankHoliday($bankHoliday))
		{
			return;
		}

		$bankHoliday = $this->normalizeDay($bankHoliday);
		$this->bankHolidays[]=$bankHoliday;
	}

	private function normalizeDay($date) : \DateTime
	{
		if( ! $date instanceof \DateTime)
		{
			$date = new \DateTime($date);
		}
		return $date->setTime(0,0,0,0);
	}

	public function isBankHoliday($date) : bool
	{
		if( ! $this->dayRange->isWithinRange($date))
		{
			throw new InvalidDateRangeException("Bank holiday is out of date range", 1);
		}
		$date = $this->normalizeDay($date);

		return in_array($date, $this->bankHolidays);
	}
}
