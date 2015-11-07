<?php

require 'vendor/autoload.php';

use App\Lib\Csv;
use App\Lib\Args;

if ( isset($args) ) {

    $arguments = new Args($args);

}
// no arguments passed, show help
else {
    //TODO : write commandline help
    echo "help\n";
}

//$csv = new Csv('');
