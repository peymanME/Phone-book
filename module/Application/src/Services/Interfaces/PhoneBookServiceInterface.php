<?php
namespace Application\Services\Interfaces;

use Application\Models\Entities\User;
use Application\Models\Entities\PhoneBook;

interface PhoneBookServiceInterface {
    public function register($entityArray, User $user);
    public function edit ($entityArray, PhoneBook $phoneBook);
    public function getAll (User $user);
}