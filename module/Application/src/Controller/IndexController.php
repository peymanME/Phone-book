<?php
namespace Application\Controller;

use Application\Models\Forms\LoginForm;
use Application\Models\Forms\RegisterForm;
use Application\Services\IndexService;

class IndexController extends Base\ControllerBase
{
    protected $indexService;
    
    function __construct($entityManager, $authenticationService) {
        parent::__construct($entityManager);
        $this->indexService = new IndexService($entityManager, $authenticationService);
   }
   
    public function indexAction(){
        $form = new LoginForm();
        $message = null;      
        return $this->viewModel(['form' => $form, 'message' => $message]);            
    }
    
    public function loginAction(){       
        $form = new LoginForm();
        $message = null;
        $request = $this->getRequest();
        if ($request->isPost()){           
            $form->setData($this->getPost());
            if ($form->isValid()){
                $data = $form->getData();                
                $this->indexService->getLogin($data);
                $result = $this->indexService->getAuthenticate();
                if ( $result === TRUE){
                   return $this->redirect()->toRoute('phonebook');
                }
                $message = $result;
            }
        }        
        return $this->jsonModel(['form' => $form, 'message' => $message], 'application\index\index.phtml');            
    }
    
    public function registerAction(){
       $message = null;
       
       $isEdit = (int)$this->params('isEdit');
       $form = new RegisterForm();
        if ($isEdit === 1 && $this->indexService->isIdentity()){
           $this->indexService->setValues($form);
       }
       $request = $this->getRequest();
        if ($request->isPost()){
            $form->setData($this->getPost());
            if ($form->isValid()){
                $result = $this->indexService->register($form->getData());
                if ($result === 301){
                   $message = "You have already registered!!";
                }
                else {
                    ($this->indexService->isIdentity())? $this->indexService->getLogout(): null;
                    return $this->redirect()->toRoute('root', ['action'=>'login']);
                }
            }
        }
        $valueButton = ((int)$form->get('id')->getValue() !== 0)? "Save change" : "Register";
       return $this->jsonModel([
           'form'           => $form,
           'message'        => $message,
           'valueButton'    => $valueButton]);            
   }
   
     
    public function logoutAction(){
        $this->indexService->getLogout(); 
        return $this->redirect()->toRoute('root');
    }
    
    public function menuAction(){
          return $this->jsonModel(null, "layout/menu/main.phtml");                
    }
}
