<?php

namespace Core;

use \App\Auth;
use \App\Flash;

/**
 * Base controller
 *
 * PHP version 7.0
 */
abstract class Controller
{

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     *
     * @param array $route_params  Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name  Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {
    }

    /**
     * Redirect to a different page
     *
     * @param string $url the relative URL $name
     *
     * @return void
     *
     *
     */
    public function redirect($url) {
        // redirect to the specified URL
        header('Location: http://'. $_SERVER['HTTP_HOST']. $url, TRUE, 303);
        exit;
    }



    /**
     * require user to be logged in
     *
     *
     * @return void
     */
    public function requireLogin()
    {
        if (! Auth::getUser()) {
        // if user is not logged in, show a flash message
            \App\Flash::addMessage('You must be logged in to access that page.', Flash::WARNING);
            Auth::rememberRequestedUrl();
            $this->redirect ('/login');
    }}

}