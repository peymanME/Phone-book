<?php
namespace Application\Services;

use Application\Services\Interfaces\UserServiceInterface;
use Application\Models\Entities\User;

class UserService extends Base\ServiceBase implements UserServiceInterface 
{
    
    public function __construct($entityManager) {
        parent::__construct($entityManager);
    }

    public function register ($entityArray){
        $user = $this->getEntity(User::class, $entityArray);
        $user->setPassword(hash ( 'md5', $user->getPassword () ));
        return $this->save($user); 
    }
    
    public function edit ($entityArray, $user){
        $user = $this->find(User::class, $user->getid());
        $newUser = $this->getEntity(User::class, $entityArray);
        $user->setFirstName($newUser->getFirstName());
        $user->setLastName($newUser->getLastName());
        $user->setEmail($newUser->getEmail());
        $user->setPassword(hash ( 'md5', $newUser->getPassword () ));
        return $this->save($user); 
    }
    
    public function findByEmail($user){
        $array = array('Email'=>$user->getEmail());
        return $this->findBy($array);
    }
}