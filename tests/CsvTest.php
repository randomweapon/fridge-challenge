<?php

use App\Lib\Csv;

class CsvTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function TestErrorWhenNoFile()
    {
        /**
         * we want to test if no file is passed to the class
         */
        $csv = new Csv();

        $error = $csv->hasError();

        $this->assertEquals($error["error"], true);

    }

    /**
     * @test
     */
    public function TestErrorWhenFileDoesNotExist()
    {
        /**
         * we want to test if and file is not found
         */
        $csv = new Csv('invalidfile.csv');

        $error = $csv->hasError();

        $this->assertEquals($error["error"], true);

    }

    /**
     * @test
     */
    public function TestResultsValid()
    {
        /**
         * we want to make sure an array is returned
         */
        $csv = new Csv('./resources/fridge.csv');

        $this->assertEquals(is_array($csv->get()), true);

    }

}
