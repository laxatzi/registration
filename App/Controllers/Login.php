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
      $user = User::authenticate($_POST['email'], $_POST['password']);
      if ($user) {
        header('Location:http//'. $_SERVER['HTTP_HOST']. '/', TRUE, 303);
        exit;
      }
    }
   }

