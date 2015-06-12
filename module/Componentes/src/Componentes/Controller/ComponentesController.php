<?php

namespace Componentes\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Componentes\Model\Componentes;
use Componentes\Model\ComponentesTable;
use Componentes\Form\ComponentesForm;

class ComponentesController extends AbstractActionController{
    protected $componentesTable;
    
    public function indexAction(){
        return new ViewModel(array(
            'componentes' => $this->getComponentesTable()->fetchAll(),
        ));
    }
    
    public function addAction(){
        $form = new ComponentesForm();
        $request = $this->getRequest();
        
        if($request->isPost()){
            $componente = new Componentes();
            $form->setInputFilter($componente->getInputFilter());
            $form->setData($request->getPost());
            
            $data = array(
                'name' => $_POST['name'],
            );
            
            $componente->exchangeArray($data);
            $this->getComponentesTable()->saveComponente($componente);
            
            return $this->redirect()->toRoute('componentes');
        }
        
        return array('form' => $form);
        
    }
    
    public function editAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }  
        $componente = $this->getComponentesTable()->getComponente($id);
        
        $form = new ComponentesForm();
        $form->bind($componente);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        
        if($request->isPost()){
            $componentes = new Componentes();
            $form->setInputFilter($componentes->getInputFilter());
            $form->setData($request->getPost());
            
            $data = array (
                'id' => $_POST['id'],
                'name' => $_POST['componente']
            );
            
            $componentes->exchangeArray($data);
            $this->getComponentesTable()->saveComponente($componentes);
            
            return $this->redirect()->toRoute('componentes');
            
        }else{
            $componentes = $this->getComponentesTable($id)->getAllComponentes($id);
            
            foreach ($componentes as $componente){
                $id = $componente->id;
                $name = $componente->name;
            }
            
            return array(
                'id' => $id,
                'name' => $name
            );
        }
        
        
    }
    
    public function deleteAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id){
            return $this->redirect()->toRoute('componentes');
        }
        
        $request = $this->getRequest();
        
        if($request->isPost()){
            $del = $request->getPost('del', 'No');
            if($del == "Yes"){
                $id = (int) $request->getPost('id');
                $this->getComponentesTable()->deleteComponente($id);
            }
            return $this->redirect()->toRoute('componentes');
        }else{
            return array(
                'id' => $id,
                'componente' => $this->getComponentesTable()->getComponente($id)
            );
        }
        
    }
    
    public function getComponentesTable() {
        if (!$this->componentesTable) {
            $sm = $this->getServiceLocator();
            $this->componentesTable = $sm->get('Componentes\Model\ComponentesTable');
        }
        return $this->componentesTable;
    }
}

