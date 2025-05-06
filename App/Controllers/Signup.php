<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Signup extends \Core\Controller
{

    /**
     * Show the register page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Signup/new.html');
    }

   /**
     * Register a new user
     *
     * @return void
     */
    public function createAction() {
        $user = new User($_POST);

       if($user->save()) {
        View::renderTemplate('Signup/success.html');

       } else {
        View::renderTemplate('Signup/new.html', [ 'user' => $user]);

       }

    }

   /**
     * Display Signup page
     *
     * @return void
     */

     public function successAction(){
       View::renderTemplate('Signup/success.html');

     }

}
