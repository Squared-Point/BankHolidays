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
    * @var $bankHolidays
    * @var $options array
    */
    public function __construct(array $bankHolidays, array $options=[])
    {
        $this->bankHolidays = [];
        $this->name = null;
        foreach($bankHolidays as $holiday)
        {
            $this->add($holiday);
        }

    	$this->validateOptions($options);

        if(array_key_exists("name", $options))
        {
            $this->name = $options["name"];
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
        elseif( ! $date instanceof \DateTimeImmutable )
        {
            $date = new \DateTimeImmutable($date);
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
            "name?" => ":string"
        ];

        $traverser = new Traverser(new ValidatorLocator());

        if(! $traverser->check($pattern, $options))
        {
           throw new BankHolidayFormatException("Incorrect input format for BankHolidayAdmin options", 1);
        }
    }
}