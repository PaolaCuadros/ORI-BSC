<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class AjaxController extends AbstractActionController {
    public function indexAction(){
        return new ViewModel();
    }
    
    public function sumarAction(){
        var_dump("Aca"); exit();
        if($this->getRequest()->isPost()){
            $num1 = $this->request->getPost('m1');
            $num2 = $this->request->getPost('m2');
            $num3 = $num1 + $num2;
            
            $result = new JsonModel(array(
               'some_parameter' => $num1,
                'success' => true,
                'resultad' => $num3,
            ));
            
            return $result;
        }
    }
}

