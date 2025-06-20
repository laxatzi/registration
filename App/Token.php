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


    public function __construct() {
        $this->token = bin2hex(random_bytes(16));


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
        return password_hmac('sha256', $this->token, "PogN1yqiTIZaLNRSxlIkL0tscOnxsoFm");
    }



}