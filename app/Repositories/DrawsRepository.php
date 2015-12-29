<?php

namespace App\Repositories;

use App\User;
use App\Draw;

class DrawsRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function fetchAll()
    {
        return Draw::all();
    }
}