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
     * @return void
     */

    public function indexAction() {

      $this->requireLogin();

      View::renderTemplate('Restrictor/index.html');
  }
  }


