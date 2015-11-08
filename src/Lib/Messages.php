<?php namespace App\Lib;

/**
 * Class Messages
 * @package App\Lib
 * @author Ryan Spencer <ryan@justanotherapp.com>
 */

class Messages
{
    private $message = array();
    private $helpAdded = false;

    /**
     * add allows adding additional messages for display.
     * The second param adds the help text to the display.
     * @param string $message
     * @param bool|false $addHelp
     * @return $this
     */
    public function add($message = "", $addHelp = false)
    {
        $this->message[] = $message;

        // add help to end of message
        if ( $addHelp ) {
            $this->addHelp();
        }

        return $this;
    }

    /**
     * toString will output the current message to a string
     * @return string
     */
    public function __toString()
    {
        $string = "";

        foreach( $this->message as $message ) {
            $string .= $message . "\n";
        }

        return $string;

    }

    /**
     * clear empty's the message array
     * @return $this
     */
    public function clear()
    {
        $this->message = array();
        $this->helpAdded = false;

        return $this;
    }

    /**
     * addHelp adds help text to the message for displaying to the console
     * @return $this
     */
    public function addHelp()
    {
        // do not add if already added
        if ( $this->helpAdded ) {
            return $this;
        }

        $this->helpAdded = true;

        $this->add("php src/index.php <ingredients CSV> <recipes JSON>")
            ->add(" - ingredients CSV is path to CSV file")
            ->add(" - recipes JSON is path to JSON file")
            ->add("")
            ->add("example : php src/index.php ./resources/fridge.csv ./resources/recipes.json");

        return $this;
    }
}