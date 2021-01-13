<?php

namespace App\Application\Models;
use App\Application\Models\User;

class MockUserDB
{
    public function create(User $user): int
    {
        return intval(uniqid(rand()));
    }
}