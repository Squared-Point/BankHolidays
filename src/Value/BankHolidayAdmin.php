<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays\Value;

use SquaredPoint\BankHolidays\Exception\InvalidPostalCodeException;

/*
 *  Immutable class managing bank holidays
 *
 */
class BankHolidayAdmin
{
   /**
    * @var $bankHolidays
    * @var $options array
    */
    public function __construct(array $BankHolidays, array $options)
    {
    	
    }

    public function isBankHoliday($date) : bool
    {

    }

    private function validateOptions(array $options)
    {
         $pattern = [        
            "name?" => ":string"
        ];

        $traverser = new Traverser(new ValidatorLocator());

        if(! $traverser->check($pattern, $options))
        {
           throw new BankHolidayFormatException("Incorrect input format for BankHolidayAdmin options", 1);
        }
    }
}