<?php

namespace Caracteristica\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Caracteristica\Model\Caracteristica;          
use Caracteristica\Form\CaracteristicaForm;       

class CaracteristicaController extends AbstractActionController {
    
    protected $caracteristicaTable;
    public function  indexAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        return new ViewModel(array(
            'caracteristica' => $this->getCaracteristicaTable($id)->fetchAll($id),
        ));
    }
    
    public function addAction(){
        $id_factor = $this->params()->fromRoute('id', 0);
        //var_dump($id_factor); exit();
        $form = new CaracteristicaForm();
        //$form->get('submit')->setValue('Add');
        
        $request = $this->getRequest();
        
        if($request->isPost()){
            $caracteristica = new Caracteristica();
            $form->setInputFilter($caracteristica->getInputFilter());
            $form->setData($request->getPost());
            //VAR_DUMP($id_factor); EXIT();
            $data = array(
                'ID_FACTOR' => $_POST['id_factor'],
                'CARACTERISTICA' => $_POST['caracteristica'],
                'DATE_CREATION' => date("Y/m/d"),
            );
            $caracteristica->exchangeArray($data);
            $this->getCaracteristicaTable()->saveCaracteristica($caracteristica);
        }
        return array('id' => $id_factor,  'form' => $form);
    }
    
    public function editAction(){
        
        if(isset($_POST['id'])){
            
            $id = $_POST['id'];
            
            $caracteristica1 = $this->getCaracteristicaTable($id)->getCaracteristica($id);
        
            $form = new CaracteristicaForm();
            $form->bind($caracteristica1);
            
            
            $request = $this->getRequest();
        if($request->isPost()){
            $caracteristica = new Caracteristica();
            $form->setInputFilter($caracteristica1->getInputFilter());
            $form->setData($request->getPost());
            //VAR_DUMP($id_factor); EXIT();
            $data = array(
                'ID_FACTOR' => $_POST['id_factor'],
                'CARACTERISTICA' => $_POST['caracteristica'],
                'DATE_CREATION' => date("Y/m/d"),
                'ID' =>     $_POST['id'],
            );
            $caracteristica->exchangeArray($data);
            $this->getCaracteristicaTable()->saveCaracteristica($caracteristica);
        }
        }else{
            $id = (int) $this->params()->fromRoute('id', 0);
            $caracteristica = $this->getCaracteristicaTable($id)->editCaracteristica($id);
            //));
            foreach ($caracteristica as $caract){
                $id = $caract->id;
                $carac = $caract->caracteristica;
                $fecha = $caract->date_creation;
                $id_factor = $caract->id_factor;
            }

            //return new ViewModel(array(

            return array('id' => $id,
                'caracteristica' => $carac,
                'id_factor' => $id_factor);
        }
        
        //var_dump($_POST['id']); exit();

        
        //$form->get('submit')->setAttribute('value', 'Edit');
        
        
            
       
        
//        $id = (int) $this->params()->fromRoute('id', 0);
//        
//        if(!$id){
//            return $this->redirect()->toRoute('caracteristica', array(
//                'action' => 'add'
//            ));
//        }
//        

//        
//        return array(
//            'id' => $id,
//            'form' => $form,
//        );
    }
    
    public function deleteAction(){
        
    }
    
    public function getCaracteristicaTable()    {
        if (!$this->caracteristicaTable) {
            $sm = $this->getServiceLocator();
            $this->caracteristicaTable = $sm->get('Caracteristica\Model\CaracteristicaTable');
        }
        return $this->caracteristicaTable;
    }
}

