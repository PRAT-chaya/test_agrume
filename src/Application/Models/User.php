<?php

namespace App\Application\Models;

class User 
{
    const VALID_STATUS = array(
        "Indépendant",
        "Chef d'entreprise/Commerçant",
        "Salarié",
        "Sans activité",
        "Étudiant"
    );

    protected $firstName;
    protected $lastName;
    protected $username;
    protected $emailAddr;
    protected $hashedPw;
    protected $professional;
    protected $status;
    protected $signature;

    public function __construct($firstName, $lastName, $emailAddr, $hashedPw, $professional) 
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->emailAddr = $emailAddr;
        $this->hashedPw = $hashedPw;
        $this->status = null;
        $this->signature = null;
        $this->professional = $professional;
    }

    public function getFirstName(): String{
        return $this->firstName;
    }

    public function getLastName(): String {
        return $this->lastName;
    }

    public function getEmailAddr(): String {
        return $this->emailAddr;
    }

    public function getHashedPw(): String {
        return $this->hashedPw;
    }

    public function getStatus(): String {
        return $this->status;
    }

    public function getSignature(): String {
        return $this->signature;
    }

    public function getUsername(): String {
        return $this->username;
    }

    public function isProfessional(): bool {
        return $this->professional;
    }

    public function setStatus(String $status) {
        $this->status = $status;
    }

    public function setSignature(String $signature) {
        $this->signature = $signature;
    }

    public function setUsername(String $username) {
        $this->username = $username;
    }
}