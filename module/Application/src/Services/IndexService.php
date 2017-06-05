<?php
namespace Application\Services;

use Application\Services\Interfaces\IndexServiceInterface;

class IndexService implements IndexServiceInterface{

    protected $userService;
    protected $authService;
    protected $entityManager;
    
    public function __construct($entityManager, $authenticationService) {       
        $this->userService = new UserService($entityManager);
        $this->authService = $authenticationService;
        $this->entityManager = $entityManager;
    }
    
    public function getLogin($data){
        $adapter = $this->authService->getAdapter();
        $adapter->setOptions(array( 
            'objectManager'     => $this->entityManager, 
            'identityClass'     => 'Application\Models\Entities\User', 
            'identityProperty'  => 'Email', 
            'credentialProperty'=> 'Password' ));
        $adapter->setIdentity($data['Email']);
        $adapter->setCredential(hash ( 'md5', $data['Password']));
        return $adapter;
    }
    
    public function getAuthenticate(){
        $authResult = $this->authService->authenticate();
        if ($authResult->isValid()) {
            $identity = $authResult->getIdentity();
            $this->authService->getStorage()->write($identity);
            return true;
        }
        return $authResult->getMessages();
    }
    
    public function isIdentity(){
        $loggedUser = $this->authService->getIdentity();
        if (isset($loggedUser)){
            return true;
        }
        return false;
    }
    
    public function getLogOut(){
        $this->authService->getStorage()->clear();
    }
    
    public function register($data){
        if ($this->isIdentity()){
            $this->userService->edit($data, $this->getIdentity());
        }else {
           $this->userService->register($data);
        }
    }
    
    public function getName(){
        $loggedUser = $this->authService->getIdentity();
        if(isset($loggedUser)){
            return $loggedUser->getFullName();
        }
        return null;
    }
    public function getIdentity(){
        $loggedUser = $this->authService->getIdentity();
        if (isset($loggedUser)){
            return $loggedUser;
        }
        return null;
    }

    public function setValues($form){
        $user = $this->getIdentity()->getArrayValue();
        $form->setData($user);
    }
} 
