<?php

namespace App;

/**
 * Authentication
 *
 * This class provides methods for user authentication.
 * It allows checking if a user is logged in, getting the current user,
 */

class Auth
{
  /**
   * Login the user by setting the user ID in the session.
   *
   * @param User $user The user object to log in.
   * @return void
   *
   */
  public static function login($user){
    // regenerate the session to prevent session fixation attacks
        session_regenerate_id(true);
        // store the user id in the session
        // this is used to identify the user in other parts of the application
        $_SESSION['user_id'] = $user->id;
  }

  /**
   * Logout the user by clearing the session.
   * @return void
   *
   */

public static function logout()   {
   /// Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
        // redirect to the login page

}

/**
 * Check if the user is logged in.
 * @return bool True if the user is logged in, false otherwise.
 */
public static function isLoggedIn() {
    // check if the user id is set in the session
    return isset($_SESSION['user_id']);
  }



}