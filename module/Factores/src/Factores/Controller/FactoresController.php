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
        if(isset($_GET['subpage'])){
            $query = $this->getFactorTable()->getAllFactorComponente($_GET['subpage']);
        }else{
             $query = $this->getFactorTable()->fetchAll();
        }
        return new ViewModel(array(
            'factores' => $query,
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
                        'idParent' => $_POST['idParent']

                    );
                    $factor->exchangeArray($data);
                    //var_dump($factor); exit();
                    $this->getFactorTable()->saveFactores($factor);
                    //$this->insert($data);
                    
                    return $this->redirect()->toRoute('factores', array(
                        'action' => 'index',
                        'id' => $_POST['idParent']
                    ));
                }
            }
        return array('form' => $form);
    }
    
    public function editAction(){
        //var_dump($_POST); exit();
        $id = (int) $this->params()->fromRoute('id', 0);
        if(isset($_POST['id'])){
            $id = $_POST['id'];
        } 
        $factores = $this->getFactorTable()->getFactores($id);

        $form  = new FactoresForm();
        $form->bind($factores);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            //var_dump($_POST); exit();
            $factores = new Factores();
            $form->setInputFilter($factores->getInputFilter());
            $form->setData($request->getPost());
            $data = array(
                'id' => $_POST['id'],
                'name' => $_POST['factor'],
                'idParent' => $_POST['idParent'],
            );
            
            $factores->exchangeArray($data);
            $this->getFactorTable()->saveFactores($factores);
            return $this->redirect()->toRoute('factores', array(
                'action' => 'index',
                'id' => $_POST['idParent']
            ));
            
            
        }else{
            
            $factores = $this->getFactorTable($id)->getFactor($id);
            
            foreach ($factores as $factor){
                $id = $factor->id;
                $name = $factor->name;
                $idParent = $factor->idParent;
            }
            
            return array(
                'id' => $id,
                'name' => $name,
                'idParent' => $idParent,
            );
        }

        
    }
    
    public function deleteAction(){
        
        $id = (int) $this->params()->fromRoute('id', 0);
        $dateFactor = $this->getFactorTable()->getFactores($id);
        
        foreach ($dateFactor as $fator){
            $idComponente = $fator;
        }

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
            
            return $this->redirect()->toRoute('factores', array(
                'action' => 'index',
                'id' => $idComponente
            ));

            // Redirect to list of albums
            //return $this->redirect()->toRoute('factores');
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

