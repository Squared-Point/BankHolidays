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
}