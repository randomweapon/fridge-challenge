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

            $error = $ingredients->hasError();

            if ( $error["error"] ) {
                $message->add($error["message"]);
            }
            else {
                // order takeout
                $message->add("All ingredients are past their used by date, Order Takeout!");
            }

        }
        else {

            // import recipes
            $recipes = new Json($arguments->get(1));

            if (! $recipes->count() ) {

                $error = $recipes->hasError();

                if ( $error["error"] ) {
                    $message->add($error["message"]);
                }
                else {
                    $message->add("No recipes found in file or JSON file is invalid");
                }

            }
            else {
                // valid files now it is time to search

                // sort ingredients by usedby date
                $ingredients->sort();

                foreach($recipes->get() as $key => $recipe) {

                    $score = 0;

                    foreach ( $recipe["ingredients"] as $recipeIngredient ) {
                        $ingredientData = $ingredients->find($recipeIngredient["item"]);

                        if ( is_array($ingredientData) ) {

                            if ( $ingredientData["amount"] >= $recipeIngredient["amount"] ) {
                                $score = $score + $ingredientData["score"];
                            }
                            else {
                                // not enough ingredients for recipe, set score to -1
                                // mark as invalid
                                $score = -1;
                                break;
                            }

                        }

                    }

                    $recipes->setScore($key, $score);

                }

                // we now have a score value for each recipe based on ingredients expiry
                // order the recipes by order
                $recipes->sort();

                // filter out all invalid recipes
                $results = $recipes->filter();

                // check to make sure there is a recipe
                //the top result is the best recipe based on the ingredients expiry
                if ( count($results) ) {
                    $result = array_shift($results);
                    $message->add("The best recipe for you to make is : " . $result["name"])
                        ->add("You need the following ingredients:");

                    foreach ( $result["ingredients"] as $ingredient ) {
                        $message->add(" - " . $ingredient["amount"] . " " . $ingredient["unit"] . " of " . $ingredient["item"]);
                    }
                    // add a blank line
                    $message->add("");

                }
                else {
                    // order takeout
                    $message->add("All ingredients are past their used by date, Order Takeout!");
                }


            }



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
