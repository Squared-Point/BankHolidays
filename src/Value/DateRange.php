<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays\Value;

use SquaredPoint\BankHolidays\Exception\InvalidDateRangeException;

class DateRange
{
	private $dateFrom;
    private $dateTo;

   /**
    * @var $dateFrom string or \DateTime
    * @var $dateTo string or \DateTime
    * @throws InvalidDateException
    */
    public function __construct($dateFrom, $dateTo)
    {
    	$dateFrom = $this->normalizeDate($dateFrom);
        $dateTo = $this->normalizeDate($dateTo);

        if($dateTo < $dateFrom)
        {
            throw new InvalidDateRangeException("First date of a range should be smaller than the second one", 1);            
        }

        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    /**
     * @var $date string or \DateTime
     * @throws InvalidDateException
     * @return \DateTime corresponding to $date (regardless of if 
     *          it was a string or a \DateTime)
    */
    private function normalizeDate($date) : \DateTime
    {
        if( ! $date instanceof \DateTime )
        {
            $date = new \DateTime($date);
        }        

        return $date->setTime(0,0,0,0);
    }

    /**
     * @var $date string or \DateTime
     * @throws InvalidDateException
     * @return bool true if $date is within $this range
    */
    public function isWithinRange($date) : bool
    {
        $date = $this->normalizeDate($date);
        if($this->dateFrom > $date)
        {
            return false;
        }

        if($date > $this->dateTo)
        {
            return false;
        }

        return true;
    }
}