<?php namespace App\Lib;

class Json
{

    private $data = array();

    public function __construct($jsonFile)
    {

        if ( file_exists($jsonFile) ) {
            $return = $this->parseJSON($jsonFile);
        }
        else {
            $return = $this->returnValue(false, "recipes JSON file does not exist");
        }

        return $return;

    }

    private function parseJSON($jsonFile)
    {
        $return = $this->returnValue(true);

        $string = file_get_contents($jsonFile);
        $this->data = json_decode($string, true);

        return $return;
    }

    private function returnValue($valid, $message = "")
    {
        return array(
            "valid" => $valid,
            "message" => $message
        );
    }

    public function get()
    {
        return $this->data;
    }

    public function count()
    {
        if ( is_null($this->data) || !is_array($this->data) ) {
            return 0;
        }
        else {
            return count($this->data);
        }

    }

}