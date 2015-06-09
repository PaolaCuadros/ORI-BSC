<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        
        return new ViewModel();
    }
    
    public function sumarAction(){
       var_dump("aca llega"); exit();
        if($this->getRequest()->isPost()){
            $num1 = $this->request->getPost('n1');
            $num2 = $this->request->getPost('n2');
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
