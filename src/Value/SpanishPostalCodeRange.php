<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays\Value;

use SquaredPoint\BankHolidays\Exception\InvalidPostalCodeException;

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
    	
    }

    
}