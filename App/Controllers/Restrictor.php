<?php

  namespace App\Controllers;
  use \Core\View;
  use \App\Auth;

  /**
   * Restrictor Controller
   *
   */

  class Restrictor extends \Core\Controller {
    /**
     * just show an index view
     * * @return void
     */

    public function indexAction() {
      if (! Auth::isLoggedIn()) {
        exit("Access denied. You must be logged in to view this page.");
      }
      View::renderTemplate('Restrictor/index.html');
  }
  }


