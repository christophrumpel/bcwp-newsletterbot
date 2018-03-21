<?php

namespace App\Newsletters;

use App\User;

interface Newsletter
{
    public function send(bool $debug, $command);

    public function getMessages(User $user);
}