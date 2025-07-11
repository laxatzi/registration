<?php

namespace App\Models;

class RememberedLogin extends \Core\Model
{
  /**
   * Find a remembered login by token
   *
   * @param string $token The remember token
   *
   * @return mixed RememberedLogin object if found, false otherwise
   */

    public static function findByToken($token){

      $token = new Token($token);
      $hashed_token = $token->getHash();

      $sql = 'SELECT * FROM remembered_logins WHERE token_hash = :token_hash';
      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
      $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
      $stmt->execute();
      return $stmt->fetch();

    }

    /**
     * get the user ID associated with this remembered login
     *
     * @return User the user model associated with this remembered login
     */




}