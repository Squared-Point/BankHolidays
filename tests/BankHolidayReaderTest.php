<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays;

use PHPUnit\Framework\TestCase;
use SquaredPoint\BankHolidays\BankHolidayReader;

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
}
