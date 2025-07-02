<?php

namespace App;
use App\Models\User;
/**
 * Authentication
 *
 * PHP version 7.0
 */
class Auth
{
    /**
     * Login the user
     *
     * @param User $user The user model
     * @param boolean $remember_me Remember the login if true
     *
     * @return void
     */
    public static function login($user, $remember_me = false)
    {
    // Regenerate session ID to prevent session fixation attacks

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user->id;

        // If remember me is true, set a cookie with the user ID
        if ($remember_me) {
           if ( $user->rememberLogin()) {
                // Set a cookie with the user ID and remember token
                setcookie('remember_me', $user->remember_token, $user->expiry_timestamp, '/');
            } else {
                // Handle error if remember login failed
                throw new \Exception('Failed to remember login.');
            }
        }
    }


    /**
     * Logout the user
     *
     * @return void
     */
    public static function logout()
    {

        // Unset all of the session variables
        $_SESSION = [];

        // Delete the session cookie
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // Finally destroy the session
        session_destroy();
    }



    /**
     * Remember the original requested URL
     *
     * @return void
     */
    public static function rememberRequestedUrl(){

        $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];

    }

    /**
     * Get the original requested URL
     * @return string
     */
    public static function get_return_to(){

        $url = $_SESSION['return_to'] ?? '/';
        unset($_SESSION['return_to']);
        return $url;

    }
        // return $url;



    /**
     * Get the currently logged in user
     *
     *  user model if logged in, null otherwise
     *
     */
    public static function getUser()
    {
        if (isset($_SESSION['user_id'])) {
            return User::findById($_SESSION['user_id']);
        }
    }

}

