<?php
namespace Application\Controller\Base;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\RemoteAddress;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class ControllerBase extends AbstractActionController {
    
    protected $entityManager;

    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    protected function getClientAddress(){
        $remote = new RemoteAddress();
        return $remote->getIpAddress();
    }

    protected function getClientStatus(){
        return array('Ip'=> $this->getClientAddress(), 'Path'=> get_class($this), 'Controller' => $this->getControllerName(), 'Action'=>$this->getActionName() );
    }

    protected function getActionName(){
        return $this->params('action');
    }

    protected function getControllerName(){
        $pieces = explode("\\", $this->params('controller'));
        return end($pieces) ;
    }

    protected function ActiveMenu(){
        $this->layout ()->setVariable ( 'manageMenuActive', '#'. $this->getControllerName() );
    }

    protected function jsonModel($variableArray=null, $template=null){
        $jsonModel = new JsonModel();
        return $this->getModel($jsonModel, $variableArray, $template);
    }

    protected function viewModel($variableArray=null, $template=null){
        $viewModel = new ViewModel();
        return $this->getModel($viewModel, $variableArray, $template);
    }
    
    private function getModel($model, $variableArray, $template){
        if (!is_null($variableArray)){
            $model->setVariables ( $variableArray );
        }
        if (!is_null($template)){
            $model->setTemplate ($template);
        }
        return $model;
    }
    
    protected function getPost(){
        $post_date = file_get_contents("php://input");
        return json_decode($post_date, true);
    }
}
