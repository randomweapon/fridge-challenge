<?php namespace App\Lib;

/**
 * Class Args
 * @package App\Lib
 * @author Ryan Spencer <ryan@justanotherapp.com>
 */

class Args
{

    private $args = array();

    public function __construct($args = array())
    {
        if ( empty($args) )
            return false;

        $this->parseArgs($args);
    }

    private function parseArgs($args)
    {

        foreach( $args as $key => $arg ) {

            // we want to skip over first arg as it is the path to the file being called
            if ( $key > 0 ) {

                // save arg to array
                $this->args[] = $arg;
            }

        }
    }

    public function get($pos = null)
    {
        if ( ! is_null($pos) ) {

            // make sure value passed in an int
            $pos = intval($pos);

            // check to see if the position is within the range of values of the array
            if ( $pos > count($this->args) && $pos >= 0 ) {
                throw new \Exception("Argument at position " . $pos . " not found");
            }

            // return value at position
            return $this->args[$pos];
        }
        else {

            // return whole array
            return $this->args;
        }
    }

    public function count()
    {
        return count($this->args);
    }

}