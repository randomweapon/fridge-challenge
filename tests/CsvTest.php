<?php

use App\Lib\Csv;

class CsvTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function ValidFileIsPassedToCSV()
    {
        /**
         * we want to make sure not exception is thrown for a invalid file
         */
        $csv = new Csv('');
    }


}
