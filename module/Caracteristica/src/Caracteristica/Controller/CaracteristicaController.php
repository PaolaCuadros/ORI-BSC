<?php

namespace Caracteristica\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Caracteristica\Model\Caracteristica;
use Caracteristica\Form\CaracteristicaForm;


use PHPUnit_Framework_TestCase;
use PHPUnit_Framework_ExpectationFailedException;
use Zend\Console\Console;
use Zend\EventManager\StaticEventManager;
use Zend\Http\Request as HttpRequest;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\Exception\LogicException;
use Zend\Stdlib\Parameters;
use Zend\Stdlib\ResponseInterface;
use Zend\Uri\Http as HttpUri;

class CaracteristicaController extends AbstractActionController {

    protected $caracteristicaTable;
    protected $factoresTable;







    public function indexAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        return array(
            'caracteristica' => $this->getCaracteristicaTable($id)->getCaracteristicaFactor($id, 0),
            'Idcomponente' => $this->getFactorTable()->getFactorComponente($id)
        );
        
//        return new ViewModel(array(
//            'caracteristica' => $this->getCaracteristicaTable($id)->getCaracteristicaFactor($id),
//        ));
    }

    public function addAction() {
        $id_factor = $this->params()->fromRoute('id', 0);
        //var_dump($id_factor); exit();
        $form = new CaracteristicaForm();
        //$form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if ($request->isPost()) {

            $caracteristica = new Caracteristica();
            $form->setInputFilter($caracteristica->getInputFilter());
            $form->setData($request->getPost());
            $data = array(
                'ID_FACTOR' => $_POST['id_factor'],
                'CARACTERISTICA' => $_POST['caracteristica'],
                'DATE_CREATION' => date("Y/m/d"),
            );
            $caracteristica->exchangeArray($data);
            $this->getCaracteristicaTable()->saveCaracteristica($caracteristica);
        }else{
            return array('id' => $id_factor, 'form' => $form);
        }
        
    }

    public function editAction() {
        
        if (isset($_POST['id'])) {

            $id = $_POST['id'];

            $caracteristica1 = $this->getCaracteristicaTable($id)->getCaracteristica($id);

            $form = new CaracteristicaForm();
            $form->bind($caracteristica1);


            $request = $this->getRequest();
            
            if ($request->isPost()) {
                
                $caracteristica2 = $this->getCaracteristicaTable($id)->fetchAll($id);
           
                foreach ($caracteristica2 as $caract) {
                    $id_factor = $caract->id_factor;
                }
                
                $caracteristica = new Caracteristica();
                $form->setInputFilter($caracteristica1->getInputFilter());
                $form->setData($request->getPost());
                //VAR_DUMP($id_factor); EXIT();
                $data = array(
                    'ID_FACTOR' => $id_factor,
                    'CARACTERISTICA' => $_POST['caracteristica'],
                    'DATE_CREATION' => date("Y/m/d"),
                    'ID' => $_POST['id'],
                );
                $caracteristica->exchangeArray($data);
                $this->getCaracteristicaTable()->saveCaracteristica($caracteristica);
                

                return $this->redirect()->toRoute('caracteristica', array(
                    'action' => 'index',
                    'id' => $id_factor
                ));
            }
        } else {
            $id = (int) $this->params()->fromRoute('id', 0);
            $caracteristica = $this->getCaracteristicaTable($id)->editCaracteristica($id);
            //));
            foreach ($caracteristica as $caract) {
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


    }

    public function deleteAction() {
       $id_factor = 0;
        $id = (int) $this->params()->fromRoute('id', 0);
        
        $caracteristica = $this->getCaracteristicaTable($id)->getCaracteristicaId($id);
           
            foreach ($caracteristica as $caract) {
                $id_factor = $caract->id_factor;
            }
       
        
        if (!$id) {
            return $this->redirect()->toRoute('caracteristica');
        }
  
        $request = $this->getRequest();

        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getCaracteristicaTable()->deleteCaracteristica($id);
            }
            
            return $this->redirect()->toRoute('caracteristica', array(
                'id' => $id_factor
            ));
        }else{
            return array(
                'id'    => $id,
                'caracteristica' => $this->getCaracteristicaTable()->getCaracteristica($id)
            );
        }


    }

    public function getCaracteristicaTable() {
        if (!$this->caracteristicaTable) {
            $sm = $this->getServiceLocator();
            $this->caracteristicaTable = $sm->get('Caracteristica\Model\CaracteristicaTable');
        }
        return $this->caracteristicaTable;
    }
    
    public function presupuestadoOriAction(){

    }
    
    public function getFactorTable(){
        if (!$this->factoresTable) {
            $sm = $this->getServiceLocator();
            $this->factoresTable = $sm->get('Factores\Model\FactoresTable');
        }
        return $this->factoresTable;
    }

}
