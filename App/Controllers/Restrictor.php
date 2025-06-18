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
     * Require the user to be authenticated before allowing access to the action methods
     *
     * @return void
     */
    protected function before() {

        $this->redirect('/login');
      }



    /**
     * just show an index view
     * @return void
     */

    public function indexAction() {

      $this->requireLogin();

      View::renderTemplate('Restrictor/index.html');
  }

  /**
   * Show the new view
   *
   * @return void
   */

  public function newAction() {

    $this->requireLogin();

    View::renderTemplate('Restrictor/new.html');
  }

  }


