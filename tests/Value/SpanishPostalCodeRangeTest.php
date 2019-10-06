<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays;

use SquaredPoint\BankHolidays\Value\SpanishPostalCode;

use PHPUnit\Framework\TestCase;

class SpanishPostalCodeRangeTest extends TestCase
{

    public function correctSpanishPostalCodeRangesProvider()
    {
        return array(
          array('08018', '13200'),
          array('13200', '13200')          
        );
    }

    public function incorrectSpanishPostalCodeRangesProvider()
    {
        return array(
          array('13205', '08018')
        );
    }

    protected function setUp() : void
    {
        
    }

    /**     
     * @dataProvider correctSpanishPostalCodeRangesProvider
     */
    public function testCorrectSpanishPostalCodeRanges($postalCodeFrom, $postalCodeTo) : void
    {
        try
        {
          new SpanishPostalCodeRange($postalCodeFrom, $postalCodeTo);
        }
        catch(\Exception $e)
        {
          $this->assertTrue(false);
        }

        $this->assertTrue(true);
    }

    /**
     * @dataProvider incorrectSpanishPostalCodeRangesProvider
     * @expectedException SquaredPoint\BankHolidays\Exception\InvalidPostalCodeRangeException
     */
    public function testIncorrectLenghtPostalCodes($postalCodeFrom, $postalCodeTo) : void
    {
        new SpanishPostalCodeRange($postalCodeFrom, $postalCodeTo);
    }
}
