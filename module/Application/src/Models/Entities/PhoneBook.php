<?php

namespace Application\Models\Entities;

use Application\Models\Entities\Abstracts\Entity;
use Application\Models\Entities\User;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity(repositoryClass="Application\Models\Entities\Repositories\PhoneBookRepository") */
class PhoneBook extends Entity{

    public function __construct() {
        $this->User 		= new User ();
    }
    
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;
	public function setid($id) {
            $this->id = $id;
            return $this;
	}
	public function getid() {
            return $this->id;
	}

        /** @ORM\Column(type="string") */
    protected $Email;
	public function setEmail($email) {
            $this->Email = $email;
            return $this;
	}
	public function getEmail() {
            return $this->Email;
	}

        /** @ORM\Column(type="string") */
    protected $HomePhone;
	public function setHomePhone($homePhone) {
            $this->HomePhone = $homePhone;
            return $this;
	}
	public function getHomePhone() {
            return $this->HomePhone;
	}
        
    /** @ORM\Column(type="string") */
    protected $MobilePhone;
	public function setMobilePhone($mobilePhone) {
            $this->MobilePhone = $mobilePhone;
            return $this;
	}
	public function getMobilePhone() {
            return $this->MobilePhone;
	}

    /** @ORM\Column(type="string") */
    protected $FirstName;
	public function setFirstName($firstName) {
		$this->FirstName = $firstName;
		return $this;
	}
	public function getFirstName() {
		return $this->FirstName;
	}
        
    /** @ORM\Column(type="string") */
    protected $LastName;
	public function setLastName($lastName) {
		$this->LastName = $lastName;
		return $this;
	}
	public function getLastName() {
		return $this->LastName;
	}
	public function getFullName() {
		return $this->getFirstName () . ' ' . $this->getLastName ();
	}

    /** @ORM\Column(type="string") */
    protected $WorkTitle;
	public function setWorkTitle($workTitle) {
		$this->WorkTitle = $workTitle;
		return $this;
	}
	public function getWorkTitle() {
		return $this->WorkTitle;
	}
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="User_id", referencedColumnName="id")
     */
    protected $User;
	public function setUser($user) {
		$this->User = $user;
		return $this;
	}
	public function getUser() {
		return $this->User;
	}
        
    public function exchangeArray($data) {
        $this->id 		= (! empty ( $data [$this->getFieldName('id')] )) 		? $data [$this->getFieldName('id')] 		: null;
        $this->FirstName 	= (! empty ( $data [$this->getFieldName('FirstName')] )) 	? $data [$this->getFieldName('FirstName')] 	: null;
        $this->LastName 	= (! empty ( $data [$this->getFieldName('LastName')] )) 	? $data [$this->getFieldName('LastName')] 	: null;
        $this->HomePhone   	= (! empty ( $data [$this->getFieldName('HomePhone')] ))        ? $data [$this->getFieldName('HomePhone')] 	: null;
        $this->MobilePhone   	= (! empty ( $data [$this->getFieldName('MobilePhone')] ))      ? $data [$this->getFieldName('MobilePhone')] 	: null;
        $this->WorkTitle   	= (! empty ( $data [$this->getFieldName('WorkTitle')] ))        ? $data [$this->getFieldName('WorkTitle')] 	: null;
        $this->Email 		= (! empty ( $data [$this->getFieldName('Email')] )) 		? $data [$this->getFieldName('Email')] 		: null;
        $this->User->exchangeArray ( $data );
   }

    public function getArrayValue (){
        return [
            'id'            => $this->id,
            'FirstName'     => $this->FirstName,
            'LastName'      => $this->LastName ,
            'HomePhone'     => $this->HomePhone ,
            'MobilePhone'   => $this->MobilePhone ,
            'WorkTitle'     => $this->WorkTitle ,
            'Email'         => $this->Email,
            'User_id'       => $this->User->getid() ,
       ];
    }	
}
