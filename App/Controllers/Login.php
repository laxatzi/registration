<?php

  namespace App\Controllers;

  use \Core\View;

  /**
   * Login Controller
   *
   *
   */

   Class Login extends \Core\Controller {
    /**
     * Show the login page
     *
     * return void
     *
     */

     public function newAction() {
        View::renderTemplate('Login/login.html');

     }
   }