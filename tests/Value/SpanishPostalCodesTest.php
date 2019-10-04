<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays;

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
          array(13200),
          array(5.56),
          array(new \DateTime()),
          array(null)
        );
    }

    public function isGreaterThanProvider()
    {
      return [
        [new SpanishPostalCode('08045'), '08018'],
        [new SpanishPostalCode('13018'), '08045'],
        [new SpanishPostalCode('25008'), '08015'],
        [new SpanishPostalCode('65218'), '45033'],

        [new SpanishPostalCode('08045'), new SpanishPostalCode('08018')],
        [new SpanishPostalCode('13018'), new SpanishPostalCode('08045')],
        [new SpanishPostalCode('25008'), new SpanishPostalCode('08015')],
        [new SpanishPostalCode('65218'), new SpanishPostalCode('45033')]
      ];
    }

    public function isNotGreaterThanProvider()
    {
      return [
        [new SpanishPostalCode('08018'), '08045'],
        [new SpanishPostalCode('08045'), '13018'],
        [new SpanishPostalCode('08015'), '25008'],
        [new SpanishPostalCode('45033'), '65218'],

        [new SpanishPostalCode('08018'), new SpanishPostalCode('08045')],
        [new SpanishPostalCode('08045'), new SpanishPostalCode('13018')],
        [new SpanishPostalCode('08015'), new SpanishPostalCode('25008')],
        [new SpanishPostalCode('45033'), new SpanishPostalCode('65218')],

        [new SpanishPostalCode('45033'), '45033'],
        [new SpanishPostalCode('45033'), new SpanishPostalCode('45033')],

        [new SpanishPostalCode('45033'), '6521'],
        [new SpanishPostalCode('45033'), '6521e']
      ];

      $finalCps = [];
      foreach($baseCps as $cpPair)
      {
        $firstCp = new SpanishPostalCode($cpPair[0]);
        $secondCpText = $cpPair[1];
        $secondCpObject = new SpanishPostalCode($cpPair[1]);

        $finalCps[] = [$firstCp, $secondCpText];
        $finalCps[] = [$firstCp, $secondCpObject];
      }

      return $finalCps;
    }

    protected function setUp() : void
    {
        
    }

    /**     
     * @dataProvider correctSpanishPostalCodesProvider
     */
    public function testCorrectSpanishPostalCodes($rawPostalCode) : void
    {
        try
        {
          new SpanishPostalCode($rawPostalCode);
        }
        catch(\Exception $e)
        {
          $this->assertTrue(false);
        }

        $this->assertTrue(true);
    }

    /**
     * @dataProvider incorrectLengthSpanishPostalCodesProvider
     * @expectedException SquaredPoint\BankHolidays\Exception\InvalidPostalCodeException
     */
    public function testIncorrectLenghtPostalCodes($rawPostalCode) : void
    {
        new SpanishPostalCode($rawPostalCode);
    }

    /**
     * @dataProvider incorrectCharSpanishPostalCodesProvider
     * @expectedException SquaredPoint\BankHolidays\Exception\InvalidPostalCodeException
     */
    public function testIncorrectCharPostalCodes($rawPostalCode) : void
    {
        new SpanishPostalCode($rawPostalCode);
    }

    /**
     * @dataProvider incorrectTypeSpanishPostalCodesProvider
     * @expectedException SquaredPoint\BankHolidays\Exception\InvalidPostalCodeException
     */
    public function testIncorrectTypePostalCodes($rawPostalCode) : void
    {
        new SpanishPostalCode($rawPostalCode);
    }

    /**
    * @dataProvider isGreaterThanProvider
    */
    public function testIsGreaterThan($firstCp, $secondCp) : void
    {
        $this->assertTrue($firstCp->isGreaterThan($secondCp));
    }

    /**
    * @dataProvider isNotGreaterThanProvider
    */
    public function testIsNotGreaterThan($firstCp, $secondCp) : void
    {
        $this->assertFalse($firstCp->isGreaterThan($secondCp));
    }
}
