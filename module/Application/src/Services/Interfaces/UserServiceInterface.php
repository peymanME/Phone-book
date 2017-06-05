<?php
namespace Application\Services\Interfaces;
interface UserServiceInterface {
    public function register ($entityArray);
    public function edit ($entityArray, $user);
    public function findByEmail($user);
}