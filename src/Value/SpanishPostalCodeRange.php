<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays\Value;

use SquaredPoint\BankHolidays\Exception\InvalidPostalCodeRangeException;

class SpanishPostalCodeRange
{
	private $postalCodeFrom;
    private $postalCodeTo;

   /**
    * @var $rawPostalCode string or SpanishPostalCode
    * @var $rawPostalCode string or SpanishPostalCode
    * @throws InvalidPostalCodeException
    */
    public function __construct($postalCodeFrom, $postalCodeTo)
    {
    	$postalCodeFrom = $this->normalizeSpanishPostalCode($postalCodeFrom);
        $postalCodeTo = $this->normalizeSpanishPostalCode($postalCodeTo);

        if(! $postalCodeTo->isGreaterThanOrEqualTo($postalCodeFrom))
        {
            throw new InvalidPostalCodeRangeException("First Postal Code of a range should be smaller than the second one", 1);            
        }

        $this->postalCodeFrom = $postalCodeFrom;
        $this->postalCodeTo = $postalCodeTo;
    }

    /**
     * @var $cp string or SpanishPostalCode
     * @throws InvalidPostalCodeException
     * @return SpanishPostalCode corresponding to $cp (regardless of if 
     *          it was a string or a SpanishPostalCode)
    */
    private function normalizeSpanishPostalCode($cp) : SpanishPostalCode
    {
        if( $cp instanceof SpanishPostalCode )
        {
            return $cp;
        }
        else
        {
            return new SpanishPostalCode($cp);
        }
    }

    /**
     * @var $cp string or SpanishPostalCode
     * @throws InvalidPostalCodeException
     * @return bool true if $cp is within $this range
    */
    public function isWithinRange($cp) : bool
    {
        $cp = $this->normalizeSpanishPostalCode($cp);
        if($this->postalCodeFrom->isGreaterThan($cp))
        {
            return false;
        }

        if($cp->isGreaterThan($this->postalCodeTo))
        {
            return false;
        }

        return true;
    }
}