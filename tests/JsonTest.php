<?php

use App\Lib\Json;

class JsonTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function TestErrorWhenNoFile()
    {
        /**
         * we want to test if no file is passed to the class
         */
        $json = new Json();

        $error = $json->hasError();

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
        $json = new Json('invalidfile.json');

        $error = $json->hasError();

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
        $json = new Json('./resources/recipes.json');

        $this->assertEquals(is_array($json->get()), true);

    }

}
