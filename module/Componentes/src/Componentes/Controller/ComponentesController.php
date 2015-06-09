<?php

namespace Componentes\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Componentes\Model\Componentes;          
use Componentes\Form\ComponentesForm; 

class ComponentesController extends AbstractActionController{
    
    protected $componentesTable;
    
    public function indexAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        return new ViewModel(array(
            'componentes' => $this->getComponentesTable($id)->fetchAll(),
        ));
    }
    
    public function addAction(){
        
    }
    
    public function editAction(){
        
    }
    
    public function deleteAction(){
        
    }
    
    public function getComponentesTable() {
        if (!$this->componentesTable) {
            $sm = $this->getServiceLocator();
            $this->componentesTable = $sm->get('Componentes/Model/ComponentesTable');
             
        }
        return $this->componentesTable;
    }
} 

