<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays\Value;

use SquaredPoint\BankHolidays\Exception\InvalidPostalCodeException;
use PASVL\Traverser\VO\Traverser;
use PASVL\ValidatorLocator\ValidatorLocator;


/*
 *  Immutable class managing bank holidays
 */
class BankHolidayAdmin
{

   /**
    * @var $bankHolidays
    * @var $options array
    */
    public function __construct(array $bankHolidays, array $options=[])
    {
        
    }


    public function isBankHoliday($date) : bool
    {
        return false;
    }
}