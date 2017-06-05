<?php
namespace Application\Services\Interfaces;

interface IndexServiceInterface {
 
    public function getLogin($data);
    public function getAuthenticate();
    public function isIdentity();
    public function getLogOut();
    public function register($data);
    public function getName();
    public function getIdentity();
    public function setValues($form);
}