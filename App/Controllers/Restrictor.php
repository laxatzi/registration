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
        $this->redirect('/login');
      }
      View::renderTemplate('Restrictor/index.html');
  }
  }


