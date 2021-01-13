<?php

namespace App\Application\Models;

use App\Application\Models\User;

class UserBuilder 
{
    const NAME_BANNED_CHARS = array(
        "<",">",",", "?", ";", ".", ":", "/", "§",
        "!","#","{", "}", "(", ")", "[", "]",
        "|", "`", "'", '"', "\\", "^", "°",
        "+", "=", "*", "%", "~"
    );
    
    const FIRSTNAME_REF = "firstName";
    const LASTNAME_REF = "lastName";
    const USERNAME_REF = "username";
    const EMAILADDR_REF = "emailAddr";
    const PASSWORD_REF = "password";
    const PROFESSIONAL_REF = "professional";
    const STATUS_REF = "socialStatus";
    const SIGNATURE_REF = "signature";

    const REFS = array(
        self::FIRSTNAME_REF, self::LASTNAME_REF, self::USERNAME_REF,
        self::EMAILADDR_REF, self::PASSWORD_REF, self::PROFESSIONAL_REF,
        self::STATUS_REF, self::SIGNATURE_REF
    );

    public $data;
    private $errors;

    public function __construct(array $data = null)
    {
        $this->data = $data;
        $this->error = null;
        require_once 'is_email.php';
    }
    
    public function createUser(): User
    {
        if(!key_exists(self::FIRSTNAME_REF, $this->data) || 
            !key_exists(self::LASTNAME_REF, $this->data) ||
            !key_exists(self::EMAILADDR_REF, $this->data) ||
            !key_exists(self::PASSWORD_REF, $this->data))
            throw new Exception("Missing fields for User creation");

        $user = new User(
            $this->data[self::FIRSTNAME_REF],
            $this->data[self::LASTNAME_REF],
            $this->data[self::EMAILADDR_REF], 
            $this->data[self::PASSWORD_REF],
            isset($this->data[self::PROFESSIONAL_REF])
        );
        
        if(key_exists(self::USERNAME_REF, $this->data))
            if($this->data[self::USERNAME_REF] !== null)
                $user->setUsername($this->data[self::USERNAME_REF]);
        
        if(key_exists(self::STATUS_REF, $this->data))
            if(self::isValidStatus($this->data[self::STATUS_REF]))
                $user->setStatus($this->data[self::STATUS_REF]);

        if(key_exists(self::SIGNATURE_REF, $this->data))
            if($this->data[self::SIGNATURE_REF] !== null)
                $user->setSignature($this->data[self::SIGNATURE_REF]);

        return $user;
    }

    private static function isValidStatus(String $status): bool
    {
        return array_search($status, User::VALID_STATUS) !== false;     
    }

    private static function isValidName(String $name): bool
    {
        
        if($name === "")
            return false;
        else if(preg_match("/[0-9]/i", $name) === 1)
            return false;
        else
        {
            foreach(self::NAME_BANNED_CHARS as $c)
                if(strpos($name, $c) !== false)
                    return false;
            if(mb_strlen($name, "UTF-8") <= 100)
                return true;
        }
        return false;
    } 

    public function isValid(): bool {
        $this->errors = array();
        if($this->data === null) {
            return false;
        }
        if(!key_exists(self::FIRSTNAME_REF, $this->data))
            $this->errors[self::FIRSTNAME_REF] = "Vous devez entrer un prénom";
        else if (!self::isValidName($this->data[self::FIRSTNAME_REF]))
            $this->errors[self::FIRSTNAME_REF] = "Prénom invalide";
        if(!key_exists(self::LASTNAME_REF, $this->data))
            $this->errors[self::LASTNAME_REF] = "Vous devez entrer un nom";
        else if(!self::isValidName($this->data[self::LASTNAME_REF]))
            $this->errors[self::LASTNAME_REF] = "Nom invalide";
        if(key_exists(self::USERNAME_REF, $this->data))
            if($this->data[self::USERNAME_REF] !== "")
                if (!self::isValidName($this->data[self::USERNAME_REF]))
                    $this->errors[self::USERNAME_REF] = "Pseudo invalide";
        if(!key_exists(self::EMAILADDR_REF, $this->data))
            $this->errors[self::EMAILADDR_REF] = "Vous devez entrer une adresse email";
        else if (!is_email($this->data[self::EMAILADDR_REF]))
            $this->errors[self::EMAILADDR_REF] = "Email invalide";
        if(!key_exists(self::PASSWORD_REF, $this->data))
            $this->errors[self::PASSWORD_REF] = "Vous devez entrer un mot de passe";
        if(key_exists(self::SIGNATURE_REF, $this->data))
            if(strlen($this->data[self::SIGNATURE_REF]) > 300)
                $this->errors[self::SIGNATURE_REF] = "Votre signature est trop longue";
        
        return count($this->errors) === 0;
    }

    public function getError(String $ref)
    {
        if(key_exists($ref, $this->errors))
        {
            if($this->errors[$ref] !== null)
            {
                return $this->errors[$ref];
            }
        }
        return null;
    }
}