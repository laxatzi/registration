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
     *
     * @param string $email email address to search for
     *
     * @return mixed User object if found, otherwise false
     *
     * Being STATIC means you can call it without creating an instance of the class.
     *
     */

    public static function findByEmail($email) {
         // Prepares a SQL query to get a user where the email matches the placeholder :email
         $sql = 'Select * from users where email = :email';
            //Calls a method getDB() — likely from a parent or base class. This method returns a PDO database connection.
            // static:: refers to the class where this method was called, supporting inheritance (late static binding).
            $db = static::getDB();
            //Ensures that if the database has an issue, it throws an exception rather than failing silently.
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Prepares the SQL query using PDO's prepare() method.
            // This gives you a prepared statement object, which is more secure (helps prevent SQL injection).
            $stmt = $db->prepare($sql);
            // Binds the actual $email value to the :email placeholder in the query.
            //PDO::PARAM_STR tells PDO it’s a string.
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            //Tells PDO to fetch the result as an instance of the class that called this method.
            //So if this is part of a User model, you'll get a User object back instead of a plain array or stdClass.
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            //Executes the prepared SQL statement.
            $stmt->execute();
            //Fetches one row from the result set.
            //Because of PDO::FETCH_CLASS, it returns an object of the calling class, with properties populated from the database row.
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
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false;
    }

}
