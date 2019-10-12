<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays;

use SquaredPoint\BankHolidays\Exception\JsonDecodeException;

class BankHolidayJsonBuilder
{
	private $constraintBuilders;
	private $constraintsList;
	private $children;
	private $bankHolidayList;

	public function __construct(string $bankHolidayDescriptor)
	{
		$bankHolidayArray = $this->jsonDecode($bankHolidayDescriptor);
	}

	private function jsonDecode(string $bankHolidayDescriptor) : array
	{
		return [];
	}
}
