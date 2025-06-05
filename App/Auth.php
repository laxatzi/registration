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

}