<?php namespace App\Lib;

class Json
{

    private $data = array();
    private $error;

    public function __construct($jsonFile)
    {

        if ( file_exists($jsonFile) ) {
            $this->parseJSON($jsonFile);
        }
        else {
            $this->setError("recipes JSON file does not exist");
        }

        return $this;

    }

    private function parseJSON($jsonFile)
    {
        $string = file_get_contents($jsonFile);
        $this->data = json_decode($string, true);

        return $this;
    }

    public function setScore($key, $score)
    {
        if ( intval($key) < $this->count() && intval($key) >= 0 ) {
            $this->data[$key]["score"] = $score;
        }
    }

    public function sort($col = "score")
    {
        usort($this->data, function($a, $b) use ($col) {
            return $a[$col] - $b[$col];
        });

        return $this;
    }

    public function filter($col = "score")
    {
        return array_filter($this->data, function($var) use ($col) {
            return $var[$col] != -1;
        });

    }

    public function get($pos = null)
    {
        if ( ! is_null($pos) ) {

            // make sure value passed in an int
            $pos = intval($pos);

            // check to see if the position is within the range of values of the array
            if ( $pos > count($this->data) && $pos >= 0 ) {
                throw new \Exception("can not find record at position " . $pos);
            }

            // return value at position
            return $this->data[$pos];
        }
        else {

            // return whole array
            return $this->data;
        }
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

    public function setError($message)
    {
        $this->error = $message;
    }

    public function hasError()
    {
        if ( strlen($this->error) ) {
            return array(
                "error" => true,
                "message" => $this->error
            );
        }
        else {
            return array(
                "error" => false,
                "message" => ""
            );
        }
    }

}