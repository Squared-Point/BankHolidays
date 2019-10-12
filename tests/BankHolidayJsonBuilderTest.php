<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays;

use PHPUnit\Framework\TestCase;
use SquaredPoint\BankHolidays\BankHolidayJsonBuilder;

class BankHolidayJsonBuilderTest extends TestCase
{
    protected function setUp() : void
    {
 
    }

    public function correctJsonProvider()
    {
        return [            
            ["[]"],
            ['{"x":"y"}'], 
            ['["x", "y", "z"]'],
        ];
    }

    public function incorrectJsonProvider()
    {
        return [
            [""],
            ["x"],
            ["[t]"],
            ['{"x:"y"}'], 
            ['["x", "y", "z":"t"]']
        ];
    }

    /**
    * @dataProvider correctJsonProvider
    */
    public function testCorrectJsonParsing($s) : void
    {
        $builder = new BankHolidayJsonBuilder($s);
        $this->assertTrue(true);
    }

    /**
    * @dataProvider incorrectJsonProvider
    * @expectedException SquaredPoint\BankHolidays\Exception\JsonDecodeException
    */
    public function testIncorrectJsonParsing($s) : void
    {
        $builder = new BankHolidayJsonBuilder($s);
        $this->assertTrue(false);
    }
}
