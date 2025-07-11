<?php

namespace App\Models;

use PDO;
use \App\Token;

class RememberedLogin extends \Core\Model
{

  public string $token_hash;
    public string $user_id;
    public string $expires_at;
  /**
   * Find a remembered login by token
   *
   * @param string $token The remember token
   *
   * @return mixed RememberedLogin object if found, false otherwise
   */

    public static function findByToken($token){

      $token = new Token($token);
      $token_hash = $token->getHashedValue();

      $sql = 'SELECT * FROM remembered_logins WHERE token_hash = CONVERT(:token_hash USING utf8mb4)';
      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':token_hash', $token_hash, PDO::PARAM_STR);
      $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
      $stmt->execute();
      return $stmt->fetch();

    }

    /**
     * get the user ID associated with this remembered login
     *
     * @return User the user model associated with this remembered login
     *
     *
     */

    public function getUser()
    {
        return User::findByID($this->user_id);
    }


 /**
     * See if the remember token has expired or not, based on the current system time
     *
     * @return boolean True if the token has expired, false otherwise
     */
    public function hasExpired()
    {
        return strtotime($this->expires_at) < time();
    }



}