<?php

use App\Lib\Messages;

class MessagesTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function TestMessageDisplayWhenNoMessageAdded()
    {
        /**
         * test to make sure _toString works when there is no messages added
         */
        $message = new Messages();

        $this->assertEquals(strlen($message->__toString()), 0);

    }

    /**
     * @test
     */
    public function TestAddHelpIsOnlyAddedOnce()
    {
        /**
         * test to make sure addHelp text is only added once to a message
         */
        $message = new Messages();
        $message->addHelp(); // add once
        $countAfterFirst = count($message->get());
        $message->addHelp(); // add twice
        $countAfterSecond = count($message->get());

        // first and second count should be exactly the same
        $this->assertEquals($countAfterFirst, $countAfterSecond);

    }
}
