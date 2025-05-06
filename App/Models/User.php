<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model {

    public $id;
    public $name;
    public $email;
    protected $password;
    protected $password_hash;
    protected $repeat_password;

    /**
     * Error message
     * @var array
     */

     public $errors = [];


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
     * @return boolean TRUE if use was saved, FALSE if not
     */
    public function save() {

        $this->validate();

    $password_hash = password_hash($this->password, PASSWORD_DEFAULT);


     $sql = 'INSERT INTO USERS (name, email, password ) VALUES (:name, :email, :password_hash)';

     $db = static::getDB();
     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


     $stmt = $db->prepare($sql);
     $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
     $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
     $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

     $stmt->execute();

    }


    /**
     * Validate current property values adding error messages to the error array property
     * @return void
     */

     public function validate() {
        // Name
        if ($this->name == '') {
            $this->errors[] = "Name is required!";
        }

        // Email address
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === FALSE){
            $this->errors[] = "Invalid email!";
        }

         if ($this->email == '') {
            $this->errors[] = "Email is required!";
        }

        // Password

        if (strlen($this->password) < 8) {
            $this->errors[] = "Password must bee at least eight characters long!";

        }

        if(preg_match('/.*[a-z]+.*/i', $this->password)==0) {
            $this->errors[] = "Password needs at least one letter!";
        }

          if(preg_match('/.*\d+.*/i', $this->password)==0) {
            $this->errors[] = "Password needs at least one number!";

        }

        if($this->password !== $this->repeat_password) {
            $this->errors[] = "Password should match!";
        }





     }

}
