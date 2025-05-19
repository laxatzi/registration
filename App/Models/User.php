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
    // protected $repeat_password;

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

    public function __construct($data=[]){
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
         // if no errors
        if (empty($this->errors)) {

           $password_hash = password_hash($this->password, PASSWORD_DEFAULT);


            $sql = 'INSERT INTO USERS (name, email, password ) VALUES (:name, :email, :password_hash)';

            $db = static::getDB();
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $stmt = $db->prepare($sql);
            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
            // execute() MUST be returned
           return $stmt->execute();
        }

        return false;
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
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === FALSE or $this->email == ''){
            $this->errors[] = "Invalid email!";
        }


        if($this->emailExist($this->email)) {
            $this->errors[] = "Email already in use!";
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

        // if($this->password !== $this->repeat_password) {
        //     $this->errors[] = "Password should match!";
        // }

     }

      /**
     * Check if a user record already exists with the specified email
     * @param string $email email address to search for
     * @return boolean True if a record already exists
     */

     public function emailExist($email) {

        return static::findByEmail($email) !== false;

     }

    /**
     * Find a user by email address
     *
     * @param string $email email address to search for
     *
     * @return mixed User object if found, otherwise false
     *
     */

     public static function findByEmail($email) {

         $sql = 'Select * from users where email = :email';

            $db = static::getDB();
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $stmt = $db->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            $stmt->execute();

            return $stmt->fetch();

     }

     /**
      * Authenticate user by email and password.
      *
      * @param string $email email address
      * @param string $password password

      * @return mixed The user object or if authentication fails FALSE
      */

      public static function authenticate($email, $password) {
        // First we want to find the user based on the email address
        $user = static::findByEmail($email);
        // Once user is found, we then check password
        if ($user) {
            if (password_verify($password, $user->password_hash)) {
                return $user;
            }
        }
        return false;
      }

}
