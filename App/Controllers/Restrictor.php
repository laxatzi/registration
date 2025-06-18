<?php

  namespace App\Controllers;
  use \Core\View;
  use \App\Auth;

  /**
   * Restrictor Controller
   *
   */

  class Restrictor extends Authenticated {



    /**
     * just show an index view
     * @return void
     */

    public function indexAction() {


      View::renderTemplate('Restrictor/index.html');
  }

  /**
   * Show the new view
   *
   * @return void
   */

  public function newAction() {



    View::renderTemplate('Restrictor/new.html');
  }

  }


