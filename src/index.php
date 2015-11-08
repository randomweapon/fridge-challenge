<?php
/**
 *
 */

require 'src/autoload.php';

use App\Lib\Csv;
use App\Lib\Json;
use App\Lib\Args;
use App\Lib\Messages;

date_default_timezone_set( 'Australia/Sydney' );

$message = new Messages();

if ( isset($argv) ) {

    $arguments = new Args($argv);

    if ($arguments->count() == 2) {

        $ingredients = new Csv($arguments->get(0));

        // check to see if there was any ingredients imported
        if ( !$ingredients->count() ) {

            // order takeout
            $message->add("All ingredients are past their used by date, Order Takeout!");
        }
        else {
            // sort ingredients by usedby date
            $ingredients->sort();

            $recipes = new Json($arguments->get(1));


        }

    }
    else {
        // invalid number of arguments passed
        $message->add("Invalid number of arguments", true);
    }

}
// no arguments passed, show help
else {
    $message->addHelp();
}

echo $message->__toString();
