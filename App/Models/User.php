<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model {

    /**
     * Class constructor
     *
     * @param array $data initial property values
     *
     * @return void
     */

    public function __construct($data){
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Save user model with the current property values
     * @return void
     */
    public function save() {


    }
}
