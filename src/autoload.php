<?php

/**
 * custom auto loader which does no rely on composer
 * composer autoload is only used for loading in phpunit classes
 */

spl_autoload_register(
    function($class) {

        static $classes = null;

        if ($classes === null) {

            $classes = array(
                'app\\lib\\args' => '/Lib/Args.php',
                'app\\lib\\csv' => '/Lib/Csv.php',
                'app\\lib\\messages' => '/Lib/Messages.php',
                'app\\lib\\json' => '/Lib/Json.php',
            );
        }

        $cn = strtolower($class);

        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }

    },
    true,
    false
);