<?php

  namespace App\Controllers;

  use \Core\View;
  use \App\Models\User;
  use \App\Auth;
use App\Flash;

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

        Flash::addMessage('Login successful'); // add a flash message to notify the user that login was successful
        $this->redirect(Auth::get_return_to());
      }
      else {
        Flash::addMessage('Login unsuccessful. Please check your email and password.', 'danger'); // add a flash message to notify the user that login was unsuccessful

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


