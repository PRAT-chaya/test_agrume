<?php

namespace App\Application\Controllers;

use App\Application\Views\SignupView;
use App\Application\Models\UserBuilder;
use App\Application\Models\MockUserDB;

class SignupController extends Controller
{
    private $userdb;

    public function __construct(String $saveNewUserRoute)
    {
        parent::__construct(new SignupView($saveNewUserRoute));
        $this->userdb = new MockUserDB();
    }

    public function saveNewUser(array $data) {
        $ub = new UserBuilder($data);
        if($ub->isValid())
        {
            $user = $ub->createUser();
            $userId = $this->userdb->create($user);
            $this->view->makeSuccessfulSignupPage($userId, $user);
        } else 
        {
            $this->view->makeSignupForm($ub);
        }
    } 

    public function POSTHasUB()
    {
        foreach(UserBuilder::REFS as $ref)
        {
            if(key_exists($ref, $_POST))
                if($_POST[$ref] !== null)
                    return true;
        }
        return false;
    }

    public function newUser() 
    {
        $ub = new UserBuilder();
        $this->view->makeSignupForm($ub);
    }
}