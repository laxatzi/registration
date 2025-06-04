<?php

  namespace App\Controllers;

  use \Core\View;
  use App\Models\User;

  /**
   * Login Controller
   *
   *
   */

  Class Login extends \Core\Controller {
    /**
     * Show the login page
     *
     * @return void
     *
     */

    public function loginAction() {
        View::renderTemplate('Login/login.html');

    }

    /**
    * Log in a user
    * @return void
    *
    */

    public function createAction() {
      /** check that email and password are correct */
      $user = User::authenticate($_POST['email'], $_POST['password']);
      /** If $user authenticates we direct the page to the home page Otherwise will display the login page again */
      if ($user) {
        // store the user id in the session
        // this is used to identify the user in other parts of the application
        $_SESSION['user_id'] = $user->id;

        $this->redirect('/');
      }
      else {
        View::renderTemplate('Login/login.html', [
          // pass in email address when render the template - this way the email value is preserved
          'email' => $_POST['email'],
        ]);

      }
    }


  }


