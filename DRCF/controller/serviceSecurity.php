<?php

require_once __DIR__.'/../include/appTop.php';

class ServiceSecurity {
private $connexion;
    public function __construct($mysql)
    {
        $this->connexion = $mysql;
    }

    public function registratorAction(User $user= null): ?bool
    {   
        $data = 'username, roles, password, img, im';
        $passd = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $user->setPassword($passd);
        $stmt = $this->connexion->prepare("INSERT INTO user ($data) VALUES (?,?,?,?,?)");
        $reg = $stmt->execute(array( $user->getUsername(), $user->getRoles(), $user->getPassword(), $user->getImg(), $user->getIm() ));
        $stmt = null;
        return $reg;

    }

    public function loginAction(User $user=null):?array {
        $data = 'username, roles, password';
        $clause = 'username =?';
        $stmt = $this->connexion->prepare("SELECT * FROM user WHERE $clause");
        $stmt->execute(array($user->getUsername()));
        $resArr = $stmt->fetchAll();
        if (count($resArr) != 0) {

            if ( password_verify($user->getPassword(), $resArr[0]['password']) ) {
                $stmt = null;
                return $resArr[0];
            }
            else {
                $stmt = null;
                return $stmt;
            }
        }
        $stmt = null;
        return $stmt;
        
    }

    public function getUserById(int $id):?User {
        $data = 'id, username, roles, password';
        $clause = 'id =?';
        $stmt = $this->connexion->prepare("SELECT $data FROM user WHERE $clause");
        $stmt->execute(array( $id ));
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            return $stmt;
        }
            $user = new User();
            $user->setId($resArr[0]['id']);
            $user->setUsername($resArr[0]['username']);
            $user->setRoles($resArr[0]['roles']);
            $user->setPassword($resArr[0]['password']);
            $stmt = null;
            return $user;
    }    

    // select listes of users
    public function listeUsers():?array {

        $stmt = $this->connexion->prepare("SELECT id, username FROM user");
        $stmt->execute();
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            return $stmt;
        }
        $stmt = null;
        return $resArr;
    }

}