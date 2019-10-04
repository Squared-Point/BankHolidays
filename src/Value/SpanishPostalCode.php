<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays\Value;

use SquaredPoint\BankHolidays\Exception\InvalidPostalCodeException;

class SpanishPostalCode
{
	private $postalCode;

   /**
    * @var $rawPostalCode string
    * @throws InvalidPostalCodeException
    */
    public function __construct($rawPostalCode)
    {
    	$this->checkRawPostalCodeFormat($rawPostalCode);
    	$this->postalCode = $rawPostalCode;
    }

    /**
    * @var $rawPostalCode string
    * @throws InvalidPostalCodeException
    */
    private function checkRawPostalCodeFormat($rawPostalCode)
    {
    	if( ! is_string($rawPostalCode))
    	{
			throw new InvalidPostalCodeException("Postal Code should be a string", 1);
    	}

    	if(strlen($rawPostalCode) != 5)
    	{
    		throw new InvalidPostalCodeException("Postal Code should be 6 characters long", 1);
    	}

    	foreach(str_split($rawPostalCode) as $char)
    	{
    		if(!is_numeric($char))
    		{
				throw new InvalidPostalCodeException("All postal code digits should be numeric", 1);
    		}
    	}

    	return;
    }

    /**
    * @var $cp can be any type - we absorb bad formats as NOT greater than...
    */
    public function isGreaterThan($cp) : bool
    {
        try
        {
            if( ! $cp instanceof SpanishPostalCode )
            {
                $cp = new SpanishPostalCode($cp);
            }
        }
        catch(InvalidPostalCodeException $e)
        {
            return false;
        }

        if(strcmp($this->postalCode, $cp->postalCode) > 0)
        {
            return true;
        }

        return false;
    }
}