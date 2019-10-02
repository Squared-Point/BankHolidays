<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays;

use PHPUnit\Framework\TestCase;

class BankHolidaysTest extends TestCase
{
    /**
     * @var BankHolidays
     */
    protected $bankHolidays;

    protected function setUp() : void
    {
        $this->bankHolidays = new BankHolidays;
    }

    public function testIsInstanceOfBankHolidays() : void
    {
        $actual = $this->bankHolidays;
        $this->assertInstanceOf(BankHolidays::class, $actual);
    }
}
