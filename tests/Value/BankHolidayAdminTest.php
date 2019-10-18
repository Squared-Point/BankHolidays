<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays\Value;

use PHPUnit\Framework\TestCase;

class BankHolidaysTest extends TestCase
{
    protected function setUp() : void
    {
 
    }

    private function buildBankHolidays2019() : BankHolidayAdmin
    {        
        $holidays2019 = [
                "2019-01-01", "2019-04-19", "2019-05-01", "2019-08-15",
                "2019-10-12", "2019-11-01", "2019-12-06", "2019-12-25"
        ];

        return  new BankHolidayAdmin($holidays2019);
    }

    public function correctBankHoliday2019Provider()
    {
        return [
            ["2019-01-01"], ["2019-04-19"], ["2019-05-01"], ["2019-08-15"],
            ["2019-10-12"], ["2019-11-01"], ["2019-12-06"], ["2019-12-25"],

            ["2019-01-01 12:00"], ["2019-04-19 17:00"], 
            ["2019-05-01 23:05:11"], ["2019-08-15 00:00:01"],
        ];
    }

    public function incorrectBankHoliday2019Provider()
    {
        return [
            ["2019-01-02"], ["2019-04-20"], ["2019-05-10"], ["2019-07-15"],
            ["2019-11-12"], ["2019-11-20"], ["2019-12-22"], ["2019-12-27"],

            ["2019-01-02 12:00"], ["2019-04-20 17:00"], 
            ["2019-05-10 23:05:11"], ["2019-07-15 00:00:01"],
        ];
    }

    /**
    * @dataProvider correctBankHoliday2019Provider
    */
    public function testIsBankHoliday2019($day) : void
    {
        $bh = $this->buildBankHolidays2019();
        $this->assertTrue($bh->isBankHoliday($day));        
    }

    /**
    * @dataProvider incorrectBankHoliday2019Provider
    */
    public function testIsNotBankHoliday2019($day) : void
    {
        $bh = $this->buildBankHolidays2019();
        $this->assertFalse($bh->isBankHoliday($day));        
    }

    public function testBankHolidayAdminIsImmutable() : void
    {
        $date = new \DateTime("2019-06-01 00:00:00");
        
        $bh = new BankHolidayAdmin([$date]);
        $this->assertTrue($bh->isBankHoliday("2019-06-01"), "Witness");

        $date->sub(new \DateInterval("P2W"));        

        $this->assertTrue($bh->isBankHoliday("2019-06-01"), "Immutability Test");
    }
}
