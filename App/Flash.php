<?php

namespace App;

/**
 * Flash messages
 * messages that are stored in the session and can be used to display notifications to the user
 */

class Flash {
    /**
     * Flash message types
     * These constants are used to define the type of flash message.
     */

    const SUCCESS = 'success';
    const WARNING = 'warning';
    const INFO = 'info';
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

    public static function addMessage($message, $type = 'info')
    {
        self::initFlashArray();
        $_SESSION['flash'][] = [
            'message' => $message,
            'type' => $type
        ];
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
        $_SESSION['flash'] = []; // clear messages after retrieving them. The flash messages are meant to be one-time notifications.
        return $messages;
    }


}



