<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays;

use SquaredPoint\BankHolidays\Value\SpanishPostalCode;
use SquaredPoint\BankHolidays\Value\SpanishPostalCodeRange;

use PHPUnit\Framework\TestCase;

class SpanishPostalCodeRangeTest extends TestCase
{

    public function correctSpanishPostalCodeRangesProvider()
    {
        return array(
          array('08018', '13200'),
          array('13200', '13200'),

          array(new SpanishPostalCode('08018'), '13200'),
          array(new SpanishPostalCode('13200'), '13200'),

          array(new SpanishPostalCode('08018'), new SpanishPostalCode('13200')),
          array(new SpanishPostalCode('13200'), new SpanishPostalCode('13200')),

          array('08018', new SpanishPostalCode('13200')),
          array('13200', new SpanishPostalCode('13200'))
        );
    }

    public function incorrectSpanishPostalCodeRangesProvider()
    {
        return array(
          array('13205', '08018')
        );
    }

    public function isWithinRangeProvider()
    {
        return array(
          array('08018', '13205', '08022'),
          array('08001', '08999', '08022'),
          array('08001', '08001', '08001'),
        );
    }

    public function isNotWithinRangeProvider()
    {
        return array(
          array('08018', '13205', '08005'),
          array('08001', '08999', '09022'),          
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

    /**     
     * @dataProvider isWithinRangeProvider
     */
    public function testIsWithinRange($postalCodeFrom, $postalCodeTo, $postalCodeWithin) : void
    {
        $range = new SpanishPostalCodeRange($postalCodeFrom, $postalCodeTo);
        $this->assertTrue($range->isWithinRange($postalCodeWithin));
    }

    /**     
     * @dataProvider isNotWithinRangeProvider
     */
    public function testIsNotWithinRange($postalCodeFrom, $postalCodeTo, $postalCodeWithin) : void
    {
        $range = new SpanishPostalCodeRange($postalCodeFrom, $postalCodeTo);
        $this->assertFalse($range->isWithinRange($postalCodeWithin));
    }
}
