<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays;

use PHPUnit\Framework\TestCase;
use SquaredPoint\BankHolidays\Value\DateRange;

class DateRangeTest extends TestCase
{

    public function correctDateRangesProvider()
    {
        return array(
          array('2019-10-05', '2020-12-13'),
          array('2019-10-05', '2019-10-05'),
          array('2019-10-05 11:00:22', '2020-12-13 15:16:17'),
          array('2019-10-05 11:00:22', '2019-10-05 11:00:26'),
          
          array(new \DateTime('2019-10-05'), '2020-12-13'),
          array(new \DateTime('2019-10-05'), '2019-10-05'),

          array(new \DateTime('2019-10-05'), new \DateTime('2020-12-13')),
          array(new \DateTime('2019-10-05'), new \DateTime('2019-10-05')),

          array('2019-10-05', new \DateTime('2020-12-13')),
          array('2019-10-05', new \DateTime('2019-10-05')),        
        );
    }

    public function incorrectDateRangesProvider()
    {
        return array(
          array('2020-12-13', '2019-10-05'),
        );
    }

    public function incorrectDatesProvider()
    {
      return array(
          array('2020-12-13', '20219-10-05'),
          array('2019-10-05', '2020-13-13'),
          // array('2019-11-31', '2020-12-13'),
          array('2019-13-05', '2020-12-13'),
      );
    }

    public function isWithinRangeProvider()
    {
        return array(
          array('2019-10-05', '2020-12-13', '2020-05-22'),
          array('2019-10-05', '2019-10-05', '2019-10-05'),
        );
    }

    public function isNotWithinRangeProvider()
    {
        return array(
          array('2019-10-05', '2020-12-13', '2021-05-22'),
          array('2019-10-05', '2019-10-05', '2019-10-06'),
        );
    }

    protected function setUp() : void
    {
        
    }

    /**     
     * @dataProvider correctDateRangesProvider
     */
    public function testCorrectDateRanges($dateFrom, $dateTo) : void
    {
        try
        {
          new DateRange($dateFrom, $dateTo);
        }
        catch(\Exception $e)
        {
          $this->assertTrue(false);
        }

        $this->assertTrue(true);
    }

    /**
     * @dataProvider incorrectDateRangesProvider
     * @expectedException SquaredPoint\BankHolidays\Exception\InvalidDateRangeException
     */
    public function testIncorrectDateRanges($dateFrom, $dateTo) : void
    {
        new DateRange($dateFrom, $dateTo);
    }

    /**
     * @dataProvider incorrectDatesProvider
     * @expectedException \Exception
     */
    public function testIncorrectDates($dateFrom, $dateTo) : void
    {
        new DateRange($dateFrom, $dateTo);
    }

    /**     
     * @dataProvider isWithinRangeProvider
     */
    public function testIsWithinRange($dateFrom, $dateTo, $dateWithin) : void
    {
        $range = new DateRange($dateFrom, $dateTo);
        $this->assertTrue($range->isWithinRange($dateWithin));
    }

    /**     
     * @dataProvider isNotWithinRangeProvider
     */
    public function testIsNotWithinRange($dateFrom, $dateTo, $dateWithin) : void
    {
        $range = new DateRange($dateFrom, $dateTo);
        $this->assertFalse($range->isWithinRange($dateWithin));
    }

    public function testDateRangeIsImmutable() : void
    {
        $dateFrom = new \DateTime("2019-10-15");
        $dateTo = new \DateTime("2019-11-10");
        $range = new DateRange($dateFrom, $dateTo);

        $this->assertTrue($range->isWithinRange("2019-11-01"));
        
        $dateTo->sub(new \DateInterval('P2W'));
        $this->assertTrue($range->isWithinRange("2019-11-01"));
    }
}
