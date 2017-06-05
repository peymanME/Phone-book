<?php
namespace Application\Services;

use Application\Services\Interfaces\PhoneBookServiceInterface;
use Application\Services\UserService;
use Application\Models\Entities\PhoneBook;
use Application\Models\Entities\User;

class PhoneBookService extends Base\ServiceBase implements PhoneBookServiceInterface{
    
    protected $userService;
    public function __construct($entityManager) {
        parent::__construct($entityManager);
        $this->userService = new UserService($entityManager);   
    }

    public function edit($entityArray, PhoneBook $phoneBook) {
        
    }

    public function register($entityArray,User $user) {
        $phoneBook = new PhoneBook();
        $newPhoneBook = $this->getEntity(PhoneBook::class, $entityArray);
        if((int)$newPhoneBook->getid()!== 0 ){
          $phoneBook = $this->find(PhoneBook::class, $newPhoneBook->getid());
        }
        $phoneBook->mapObjectToObject($newPhoneBook);
        $phoneBook->setUser($user);
        return $this->save($phoneBook);  
    }
    
    public function getAll (User $user){
        $array = ['User' => $user->getid()];
        return $this->findBy(PhoneBook::class, $array);
    }
    
    public function setValues($form, $id){
        $phoneBook = $this->find(PhoneBook::class, $id)->getArrayValue();
        $form->setData($phoneBook);
    }
    
    public function delete ($id){
        return $this->remove(PhoneBook::class, $id);
    }

} 
