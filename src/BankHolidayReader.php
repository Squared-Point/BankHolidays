<?php

declare(strict_types=1);

namespace SquaredPoint\BankHolidays;

use SquaredPoint\BankHolidays\Exception\InvalidBaseDirectoryException;
use SquaredPoint\BankHolidays\Exception\InvalidFilenameException;

class BankHolidayReader
{
	private $baseDir;

	public function __construct()
	{
		$baseDir = dirname(dirname(__FILE__))."/data";
		if( ! is_dir($baseDir) )
		{
			throw new InvalidBaseDirectoryException();
		}		
		$this->baseDir = $baseDir;
	}

	public function readAndParseSingleFile($filename) : array
	{
		$json = $this->readSingleFile($filename);
        $descriptor = json_decode($json, true);
        $bankHolidays = $descriptor['bank_holidays'];
        unset($descriptor['bank_holidays']);
        
        return [$bankHolidays, $descriptor];
	}

	public function readSingleFile($filename) : string
	{
		$fullFilename=$this->baseDir."/".$filename;		
		if( ! is_file($fullFilename) )
		{
			throw new InvalidFilenameException();
		}
		
		return file_get_contents($fullFilename);
	}
}
