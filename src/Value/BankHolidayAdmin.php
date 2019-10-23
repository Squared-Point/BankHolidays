<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays\Value;

use SquaredPoint\BankHolidays\Exception\BankHolidayFormatException;
use PASVL\Traverser\VO\Traverser;
use PASVL\ValidatorLocator\ValidatorLocator;


/*
 *  Immutable class managing bank holidays
 */
class BankHolidayAdmin
{

    private $bankHolidays;
    private $name;

   /**
    * @var $bankHolidays array of string or dates (possibly immutables)
    * @var $options array
    */
    public function __construct(array $bankHolidays, array $options=[])
    {
        $this->bankHolidays = [];
        $this->name = null;

        $this->initializeBankHolidays($bankHolidays);
    	$this->validateOptions($options);

        if(array_key_exists("name", $options))
        {
            $this->name = $options["name"];
        }
    }

    /**
     * @var $bankHolidays
     * @throws BankHolidayFormatException
     */
    private function initializeBankHolidays($bankHolidays)
    {
        try
        {
            foreach($bankHolidays as $holiday)
            {
                $this->add($holiday);
            }
        }
        catch( BankHolidayFormatException $e )
        {
            throw new BankHolidayFormatException("Incorrect Date format exception when initializing bank holiday administrator.");
        }
    }

    private function add($bankHoliday)
    {
        if($this->isBankHoliday($bankHoliday))
        {
            return;
        }

        $bankHoliday = $this->normalizeDay($bankHoliday);
        $this->bankHolidays[]=$bankHoliday;
    }

    private function normalizeDay($date) : \DateTimeImmutable
    {
        if($date instanceof \DateTime )
        {
            $date = \DateTimeImmutable::createFromMutable($date);
        }
        elseif( is_string($date) )
        {
            $date = new \DateTimeImmutable($date);
        }
        elseif( ! $date instanceof \DateTimeImmutable )
        {
            throw new BankHolidayFormatException("Error in date format", 1);
            
        }

        return $date->setTime(0,0,0,0);
    }

    public function isBankHoliday($date) : bool
    {
        $date = $this->normalizeDay($date);
        return in_array($date, $this->bankHolidays);
    }

    public function hasName()
    {
        return ! is_null($this->name);
    }

    public function getName()
    {
        return $this->name;
    }

    private function validateOptions(array $options)
    {
         $pattern = [        
            "name?" => ":string",
            "constraints?" => ":any",
            "children?" => ":any"
        ];

        $traverser = new Traverser(new ValidatorLocator());

        if(! $traverser->check($pattern, $options))
        {
           throw new BankHolidayFormatException("Incorrect input format for BankHolidayAdmin options", 1);
        }
    }
}