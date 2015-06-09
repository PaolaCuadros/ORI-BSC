<?php
// module/Factores/src/Factores/Controller/FactoresController.php:
namespace Factores\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Factores\Model\Factores;          // <-- Add this import
use Factores\Form\FactoresForm;       // <-- Add this import
use Zend\View\Model\JsonModel;

class FactoresController extends AbstractActionController {
    
    protected $factoresTable;
    
    
    public function indexAction(){
        return new ViewModel(array(
            'factores' => $this->getFactorTable()->fetchAll(),
        ));
    }
    
    public function addAction(){
   
        $form = new FactoresForm();
            $form->get('submit')->setValue('Add');

            $request = $this->getRequest();

            //var_dump($request->isPost()); exit();

            if ($request->isPost()) {

                $factor = new Factores();
                $form->setInputFilter($factor->getInputFilter());
                $form->setData($request->getPost());

                if (isset($_POST['name']) && $_POST['name'] != "") {
                    //var_dump($_POST['nombre']); exit();
                    $data = array(
                        'name' => $_POST['name'],

                    );
                    $factor->exchangeArray($data);
                    $this->getFactorTable()->saveFactores($factor);
                    //$this->insert($data);
                    
                    return $this->redirect()->toRoute('factores');
                }
            }
        return array('form' => $form);
    }
    
    public function editAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('factores', array(
                'action' => 'add'
            ));
        }
        $factores = $this->getFactorTable()->getFactores($id);

        $form  = new FactoresForm();
        $form->bind($factores);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($factores->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getFactorTable()->saveFactores($factores);
                
                // Redirect to list of albums
                return $this->redirect()->toRoute('factores');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }
    
    public function deleteAction(){
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('factores');
        }

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            
            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getFactorTable()->deleteFactores($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('factores');
        }
        
        return array(
            'id'    => $id,
            'factores' => $this->getFactorTable()->getFactores($id)
        );
    }
    
    public function getFactorTable()
    {
        if (!$this->factoresTable) {
            $sm = $this->getServiceLocator();
            $this->factoresTable = $sm->get('Factores\Model\FactoresTable');
        }
        return $this->factoresTable;
    }
    
    public function itemsAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
       $form = new FactoresForm();
            $form->get('submit')->setValue('Add');

            $request = $this->getRequest();

            //var_dump($request->isPost()); exit();

            if ($request->isPost()) {
                
                $factor = new Factores();
                $form->setInputFilter($factor->getInputFilter());
                $form->setData($request->getPost());

                if (isset($_POST['nombre']) && $_POST['nombre'] != "") {
                    //var_dump($_POST['nombre']); exit();
                    $data = array(
                        'name' => $_POST['nombre'],
                        'idParent' => $_POST['id_parent'],
//                        'descripcion' => $_POST['caracteristica'],

                    );
                    
                    $factor->exchangeArray($data);
                    $this->getFactorTable()->saveFactores($factor);
                    //$this->insert($data);
                    //return $this->redirect()->toRoute('factores');
                    
                    //return $this->redirect()->toRoute('factores');

                }
                return array('form' => $form, 
                    'id'    => $id,
                    'factores' => $this->getFactorTable()->itemsFactores($_POST['id_parent']),
        );
            }
            

        return array('form' => $form, 
            'id'    => $id,
            'factores' => $this->getFactorTable()->itemsFactores($id),
        );
    }
}

