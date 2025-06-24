<?php

namespace App;

/*
  * Token
  *
  * PHP version 7.0
  */

class Token {
  /*
    * the token value
    *
    * @var array
    */

    protected $token;
    /**
     * Constructor
     *
     * @return void
     */


    public function __construct($token_val=null) {
        // If a token is provided, use it; otherwise, generate a new one
        if ($token_val) {
            $this->token = $token_val;
        } else {
          $this->token = bin2hex(random_bytes(16));

        }


}

    /*
      * Get Token value
      *
      * @return string token value
    */
    public function getValue() {
        return $this->token;
    }

    /*
      * Get the Hashed Token value
      *
      * @return string hashed token value
    */

    public function getHashedValue() {
        return hash_hmac('sha256', $this->token, \App\Config::SECRET_KEY, true); //
    }



}