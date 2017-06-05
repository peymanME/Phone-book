<?php
namespace Application\Controller;

use Application\Services\IndexService;
use Application\Models\Forms\PhoneBookForm;
use Application\Services\PhoneBookService;

class PhoneBookController extends Base\ControllerBase
{
    protected $indexService;
    protected $phoneBookService;
    
    function __construct($entityManager, $authenticationService) {
        $this->indexService = new IndexService($entityManager, $authenticationService);
        $this->phoneBookService = new PhoneBookService($entityManager);
   }
   
    public function indexAction(){
       if ($this->indexService->isIdentity()){
            return $this->jsonModel();    
        }
        return $this->redirect()->toRoute('root', ['action' => 'login']);
    }
    
    public function manageAction(){
       if ($this->indexService->isIdentity()){
            $message = null;
            $id = (int)$this->params('id');
            $form = new PhoneBookForm();
            if ($id !== 0 && $this->indexService->isIdentity()){
               $this->phoneBookService->setValues($form, $id);
            }
            
            $request = $this->getRequest();
            if ($request->isPost()){
                $form->setData($this->getPost());
                if ($form->isValid()){
                    $result = $this->phoneBookService->register($form->getData(), $this->indexService->getIdentity());
                    if ($result === 301){
                        $message = "The user is duplicate!!";
                    }
                    else {
                        return $this->redirect()->toRoute('phonebook');
                    }
                }
            }
            
            if ((int)$form->get('id')->getValue() === 0){
                $signString['button'] = "Save";
                $signString['title'] = "New";
            } else {
                $signString['title'] = "Edit";
                $signString['button'] = "Save change";               
            }
            return $this->jsonModel([
                'form' => $form,
                'signString' => $signString,
                'message' => $message],
                    'application/phone-book/phone-book-form.phtml');
        }
        return $this->redirect()->toRoute('root', ['action' => 'login']);
    }
    
    public function getDataAction (){
       if ($this->indexService->isIdentity()){
            $users = $this->phoneBookService->getAll($this->indexService->getIdentity());
            $helper = new \Application\Helpers\Helper();
            $jsUsers = $helper->ArrayOfObjsToJson($users);
            return $this->jsonModel(['jsUsers' => $jsUsers]);  
       }
       return $this->redirect()->toRoute('root', ['action' => 'login']);
    }  
    
    public function deleteAction(){
        if ($this->indexService->isIdentity()){
            $id = (int)$this->params('id');
            if ($this->phoneBookService->delete($id)){
                return $this->redirect()->toRoute('phonebook', ['action' => 'getData']);
            }
            return $this->jsonModel(['typeAlert'=> 'danger', 'message'=> "There is a error to delete data!!"], "error/_alert.phtml");
        }
        return $this->redirect()->toRoute('root', ['action' => 'login']);    
    }
}
