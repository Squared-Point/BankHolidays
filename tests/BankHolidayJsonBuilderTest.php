<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays;

use PHPUnit\Framework\TestCase;
use SquaredPoint\BankHolidays\BankHolidayJsonBuilder;

class BankHolidayJsonBuilderTest extends TestCase
{

    const FORMAT_JSON = false;
    const FORMAT_ARRAY = true;

    protected function setUp() : void
    {
 
    }

    public function correctJsonProvider()
    {
        return [            
            //["[]"],
            //['{"x":"y"}'], 
            //['["x", "y", "z"]'],
            ['{"bank_holidays":[]}'],
            ['{"name":"", "bank_holidays":[]}'],
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

    private function getSimpleBankHolidaySetup($format=self::FORMAT_JSON)
    {
        $json =  '{
            "name": "Spain",
            "bank_holidays":
            [
                "2019-01-01"
            ]            
        }';

        return ($format == self::FORMAT_JSON) ? $json : json_decode($json, true);
        
    }

    public function correctFormatProvider()
    {        
        $a = $this->getSimpleBankHolidaySetup();
        
        $b = $this->getSimpleBankHolidaySetup(self::FORMAT_ARRAY);
        unset($b["name"]);
        $b = json_encode($b);

        $c = $this->getSimpleBankHolidaySetup(self::FORMAT_ARRAY);
        $c["bank_holidays"][] = "2019-01-05";
        $c = json_encode($c);

        $d = $this->getSimpleBankHolidaySetup(self::FORMAT_ARRAY);
        $d["bank_holidays"][] = "2019-01-01";
        $d = json_encode($d);
        

        return [            
            [$a],
            [$b], 
            [$c],
        ];
    }

    public function incorrectFormatProvider()
    {

        $a = $this->getSimpleBankHolidaySetup(self::FORMAT_ARRAY);
        unset($a["bank_holidays"]);
        $a = json_encode($a);

        $b = $this->getSimpleBankHolidaySetup(self::FORMAT_ARRAY);
        $b["dummy"] = "unknown field";
        $b = json_encode($b);

        $c = $this->getSimpleBankHolidaySetup(self::FORMAT_ARRAY);
        $c["bank_holidays"][] = "wrong date format";
        $c = json_encode($c);

        $d = $this->getSimpleBankHolidaySetup(self::FORMAT_ARRAY);
        $d["bank_holidays"] = "not an array";
        $d = json_encode($d);

        $e = $this->getSimpleBankHolidaySetup(self::FORMAT_ARRAY);
        $e["name"] = ["not a string", "at all"];
        $e = json_encode($d);

        return [
            [$a],
            [$b],
            [$c],
            [$d]
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

    /**
    * @dataProvider correctFormatProvider
    */
    public function testCorrectFormat($s) : void
    {
        $builder = new BankHolidayJsonBuilder($s);
        $this->assertTrue(true);
    }

    /**
    * @dataProvider incorrectFormatProvider
    * @expectedException SquaredPoint\BankHolidays\Exception\BankHolidayFormatException
    */
    public function testIncorrectFormat($s) : void
    {
        $builder = new BankHolidayJsonBuilder($s);
        $this->assertTrue(false);
    }
}
