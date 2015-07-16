<?php

namespace Ejecutado\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Ejecutado\Model\Ejecutado;          // <-- Add this import
use Ejecutado\Form\EjecutadoForm;       // <-- Add this import
use Zend\View\Model\JsonModel;
use Zend\Mail\Message;
use Zend\Mail\Transport\File as FileTransport;
use Zend\Mail\Transport\FileOptions;
use Zend\Mail\Transport\InMemory as InMemoryTransport;
use Zend\Mail\Transport\Sendmail as SendmailTransport;

class EjecutadoController extends AbstractActionController {

    protected $ejecutadoTable;
    protected $usuariosTable;
    protected $preComponentesTable;
    protected $preFactoresTable;
    protected $preCaracteristicasTable;

    public function indexAction() {
        $anioFiltra = 0;
        $selectCompi = 0;
        if(isset($_POST['anio'])){
            $anioFiltra = $_POST['anio'];
            //var_dump($anio); exit();
        }
        
        if(isset($_POST['selectCompi'])){
            $selectCompi = $_POST['selectCompi'];
        }
        //var_dump($anioFiltra); exit();
        $componentesEjecutado = $this->getPreComponentesTable()->getFactorDiuff($selectCompi);
        $componentes = $this->getPreComponentesTable()->getOneComponente(1, $selectCompi);
        $factores = $this->getPreFactoresTable();
        $caracteristicas = $this->getPreCaracteristicasTable();
        $ejecutado = $this->getUsuariosTable();
        $getejecutado = $this->getEjecutadoTable();
        $selectComponente = $this->getPreComponentesTable();
        
        return array(
            'componentes' => $componentes,
            'componentesEjecutado' => $componentesEjecutado,
            'factores' => $factores,
            'caracteristicas' => $caracteristicas,
            'ejecutado' => $ejecutado,
            'getejecutado' => $getejecutado,
            'anioFiltra' => $anioFiltra,
            'selectComponente' => $selectComponente,
            'selectCompi' => $selectCompi
        );
    }

    public function addAction() {
        //var_dump("aca"); exit();
//        //envio de correo
//        $message = new Message();
//        $message->addTo('lizeth.cuadros@unibague.edu.co')
//                ->addFrom('cuadros1605@gmail.com')
//                ->setSubject('evio')
//                ->setBody("Hola este es de prubas Paola");
//        
//        $transport = new SendmailTransport();
//        
//        $transport->send($message);
//        //Fin envio de correo




        $id = (int) $this->params()->fromRoute('id', 0);
//        $getEjecutado = $this->getEjecutadoTable()->getEjecutadoCaracteristica($id);
//        foreach ($getEjecutado as $ejecutado) {
//            $idEjecutado = $ejecutado->id;
//        }
//        if (isset($idEjecutado)) {
//            return $this->redirect()->toRoute('ejecutado', array(
//                        'action' => 'edit', 'id' => $id
//            ));
//        } else {
            $form = new EjecutadoForm();
            $request = $this->getRequest();
            if ($request->isPost()) {
                $ejecutado = new Ejecutado();
                $form->setInputFilter($ejecutado->getInputFilter());
                $form->setData($request->getPost());

                $data = array();
                if (isset($_FILES['archivo'])) {

                    if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                        $dir = __DIR__ . "/../img";
                        $tmp = $_FILES['archivo']['tmp_name'];

                        $file = $_FILES['archivo']['name'];
                        $new_path = $dir . "/" . $file;
                        //var_dump($new_path); exit();
                        if (move_uploaded_file($tmp, $new_path)) {
                            echo "El Arhivo " . $file . " fue subido con exito";
                        }
                    } else {
                        $new_path = "";
                        print ("No se ha podido subir el fichero");
                    }
                }

                $ejecutado->exchangeArray($data);
                $this->getEjecutadoTable()->saveEjecutado($ejecutado, $new_path);
                return $this->redirect()->toRoute('ejecutado', array(
                            'action' => 'index'
                ));
            }
            return array('form' => $form, 'idCaracteristica' => $id);
        //}
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $idCaracterristica = $this->getEjecutadoTable()->getCaracteristicaEjecutado($id);
        foreach ($idCaracterristica as $idCaract){
            $idCaracteris = $idCaract->IDCARACTERISTICA;
        }

        $getEjecutado = $this->getEjecutadoTable();
        $form = new EjecutadoForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $ejecutado = new Ejecutado();
            $form->setInputFilter($ejecutado->getInputFilter());
            $form->setData($request->getPost());

            $data = array();
            $new_path = "";
            if (isset($_FILES['archivo'])) {
                if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {

                    $dir = __DIR__ . "/../img";
                    $tmp = $_FILES['archivo']['tmp_name'];

                    $file = $_FILES['archivo']['name'];
                    $new_path = $dir . "/" . $file;
                    //var_dump($new_path); exit();
                    if (move_uploaded_file($tmp, $new_path)) {
                        echo "El Arhivo " . $file . " fue subido con exito";
                    }
                } else
                    print ("No se ha podido subir el fichero");
            }

            $ejecutado->exchangeArray($data);
            $this->getEjecutadoTable()->saveEjecutado($ejecutado, $new_path);
            return $this->redirect()->toRoute('ejecutado', array(
                        'action' => 'index'
            ));
        }

        return array('form' => $form, 'idCaracteristica' => $idCaracteris, 'getEjecutado' => $getEjecutado, 'id' => $id);
    }

    public function deleteAction() {
        
    }

    public function getPreComponentesTable() {
        if (!$this->preComponentesTable) {
            $sm = $this->getServiceLocator();
            $this->preComponentesTable = $sm->get('Componentes\Model\ComponentesTable');
        }
        return $this->preComponentesTable;
    }

    public function getPreFactoresTable() {
        if (!$this->preFactoresTable) {
            $sm = $this->getServiceLocator();
            $this->preFactoresTable = $sm->get('Factores\Model\FactoresTable');
        }
        return $this->preFactoresTable;
    }

    public function getPreCaracteristicasTable() {
        if (!$this->preCaracteristicasTable) {
            $sm = $this->getServiceLocator();
            $this->preCaracteristicasTable = $sm->get('Caracteristica\Model\CaracteristicaTable');
        }
        return $this->preCaracteristicasTable;
    }

    public function getUsuariosTable() {
        if (!$this->usuariosTable) {
            $sm = $this->getServiceLocator();
            $this->usuariosTable = $sm->get('Usuarios\Model\UsuariosTable');
        }
        return $this->usuariosTable;
    }

    public function getEjecutadoTable() {

        if (!$this->ejecutadoTable) {

            $sm = $this->getServiceLocator();
            $this->ejecutadoTable = $sm->get('Ejecutado\Model\EjecutadoTable');
        }
        return $this->ejecutadoTable;
    }

}
