<?php

namespace App;

/**
 * Flash messages
 * messages that are stored in the session and can be used to display notifications to the user
 */

class Flash {

    /**
     * Initialize the flash messages array in the session
     */
    public static function initFlashArray()
    {

        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }
    }


    /**
     * Add a message to the flash messages array
     *
     */

    public static function addMessage($message)
    {
        self::initFlashArray();
        $_SESSION['flash'][] = $message;
    }

    /**
     * Get all flash messages and clear them from the session
     *
     * @return array
     */
    public static function getMessages()
    {
        self::initFlashArray();
        $messages = $_SESSION['flash'];
        $_SESSION['flash'] = []; // clear messages after retrieving them
        return $messages;
    }


}



