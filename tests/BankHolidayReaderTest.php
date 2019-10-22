<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays;

use PHPUnit\Framework\TestCase;
use SquaredPoint\BankHolidays\BankHolidayReader;
use SquaredPoint\BankHolidays\Value\BankHolidayAdmin;

class BankHolidayReaderTest extends TestCase
{
    protected function setUp() : void
    {
 
    }

    public function correctFileProvider()
    {
        return [
            ["ES-only-2019.json"],
            ["ES-test-2019.json"],
            ["ES/2019/national.json"]
        ];
    }

    public function incorrectFileProvider()
    {
        return [
            ["dummy.json"]
        ];
    }

    public function correctSpanishBankHolidays()
    {
        return [
            ["2019-01-01"], 
            ["2019-04-19"], 
            ["2019-05-01"], 
            ["2019-08-15"],
            ["2019-10-12"], 
            ["2019-11-01"], 
            ["2019-12-06"], 
            ["2019-12-25"]
        ];
    }

    public function incorrectSpanishBankHolidays()
    {
        return [
            ["2019-01-02"], 
            ["2019-04-10"], 
            ["2019-05-11"], 
            ["2019-08-11"],
            ["2019-10-11"]
        ];
    }

    public function testBaseDir() : void
    {
        $reader = new BankHolidayReader();
        $this->assertTrue(true);
    }

    /**
     * @dataProvider correctFileProvider   
     */
    public function testReadSingleFile($filename) : void
    {
        $reader = new BankHolidayReader();
        $json = $reader->readSingleFile($filename);
        json_decode($json);

        $this->assertTrue(json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * @dataProvider incorrectFileProvider   
     * @expectedException SquaredPoint\BankHolidays\Exception\InvalidFilenameException
     */
    public function testIncorrectReadSingleFile($filename) : void
    {
        $reader = new BankHolidayReader();
        $json = $reader->readSingleFile($filename);
        json_decode($json);

        $this->assertTrue(json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * @dataProvider correctSpanishBankHolidays
     */
    public function testCorrectBankHoliday($day) : void
    {
        $reader = new BankHolidayReader();
        $json = $reader->readSingleFile("ES/2019/national.json");
        
        $descriptor = json_decode($json, true);
        $bankHolidays = $descriptor['bankHolidays'];
        $admin = new BankHolidayAdmin($bankHolidays);

        $this->assertTrue($admin->isBankHoliday($day));
    }

    /**
     * @dataProvider incorrectSpanishBankHolidays
     */
    public function testIncorrectBankHoliday($day) : void
    {
        $reader = new BankHolidayReader();
        $json = $reader->readSingleFile("ES/2019/national.json");

        $descriptor = json_decode($json, true);
        $bankHolidays = $descriptor['bankHolidays'];
        $admin = new BankHolidayAdmin($bankHolidays);

        $this->assertFalse($admin->isBankHoliday($day));
    }
}
