<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays;

use SquaredPoint\BankHolidays\Exception\InvalidPostalCodeException;
use SquaredPoint\BankHolidays\Value\SpanishPostalCode;



use PHPUnit\Framework\TestCase;

class SpanishPostalCodeTest extends TestCase
{

    public function correctSpanishPostalCodesProvider()
    {
        return array(
          array('08018'),
          array('13200'),
          array('28340'),
          array('46300')
        );
    }

    public function incorrectLengthSpanishPostalCodesProvider()
    {
        return array(
          array('0818'),
          array('132005'),
          array(''),
          array('00')
        );
    }


    public function incorrectCharSpanishPostalCodesProvider()
    {
        return array(
          array('0p018'),
          array('1$200'),
          array('2834*'),
          array('<6300')
        );
    }

    public function incorrectTypeSpanishPostalCodesProvider()
    {
        return array(
          array(true),
          array(1),
          array(5.56),
          array(new \DateTime())
        );
    }

    protected function setUp() : void
    {
        
    }

    /**     
     * @dataProvider correctSpanishPostalCodesProvider
     */
    public function testCorrectSpanishPostalCodes($rawPostalCode) : void
    {
        new SpanishPostalCode($rawPostalCode);
         $this->assertTrue(true);

    }

    /**
     * @dataProvider incorrectLengthSpanishPostalCodesProvider
     * @expectedException InvalidPostalCodeException
     */
    public function testIncorrectLenghtPostalCodes($rawPostalCode) : void
    {
        new SpanishPostalCode($rawPostalCode);
    }

    /**
     * @dataProvider incorrectCharSpanishPostalCodesProvider
     * @expectedException InvalidPostalCodeException
     */
    public function testIncorrectCharPostalCodes($rawPostalCode) : void
    {
        new SpanishPostalCode($rawPostalCode);
    }

    /**
     * @dataProvider incorrectTypeSpanishPostalCodesProvider
     * @expectedException InvalidPostalCodeException
     */
    public function testIncorrectTypePostalCodes($rawPostalCode) : void
    {
        new SpanishPostalCode($rawPostalCode);
    }
}
