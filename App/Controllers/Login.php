<?php

  namespace App\Controllers;

  use \Core\View;
  use \App\Models\User;
  use \App\Auth;

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

        Auth::login($user);
        $this->redirect(Auth::get_return_to());
      }
      else {
        View::renderTemplate('Login/login.html', [
          // pass in email address when render the template - this way the email value is preserved
          'email' => $_POST['email'],
        ]);

      }
    }

    /**
     * Log out a user
     *
     * @return void
     */

    public function destroyAction() {
        Auth::logout();
        $this->redirect('/');
    }


  }


