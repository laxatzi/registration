<?php


namespace App\Controllers;

abstract class Authenticated extends \Core\Controller {

  /**
     * Require the user to be authenticated before allowing access to the action methods
     *
     * @return void
     */
    protected function before() {

        $this->redirect('/login');
      }
}




