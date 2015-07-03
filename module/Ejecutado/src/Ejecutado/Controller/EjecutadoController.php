<?php

namespace Ejecutado\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Ejecutado\Model\Ejecutado;          // <-- Add this import
use Ejecutado\Form\EjecutadoForm;       // <-- Add this import
use Zend\View\Model\JsonModel;

class EjecutadoController extends AbstractActionController {

    protected $ejecutadoTable;
    protected $usuariosTable;
    protected $preComponentesTable;
    protected $preFactoresTable;
    protected $preCaracteristicasTable;

    public function indexAction() {
        $componentesEjecutado = $this->getPreComponentesTable()->getFactorDiuff();
        $componentes = $this->getPreComponentesTable()->getOneComponente(1);
        $factores = $this->getPreFactoresTable();
        $caracteristicas = $this->getPreCaracteristicasTable();
        $ejecutado = $this->getUsuariosTable();
        return array(
            'componentes' => $componentes,
            'componentesEjecutado' => $componentesEjecutado,
            'factores' => $factores,
            'caracteristicas' => $caracteristicas,
            'ejecutado' => $ejecutado
        );
    }

    public function addAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $getEjecutado = $this->getEjecutadoTable()->getEjecutadoCaracteristica($id);
        foreach ($getEjecutado as $ejecutado) {
            $idEjecutado = $ejecutado->id;
        }
        if (isset($idEjecutado)) {
            return $this->redirect()->toRoute('ejecutado', array(
                        'action' => 'edit'
            ));
        } else {
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
                    } else
                        print ("No se ha podido subir el fichero");
                }

                $ejecutado->exchangeArray($data);
                $this->getEjecutadoTable()->saveEjecutado($ejecutado, $new_path);
                return $this->redirect()->toRoute('ejecutado', array(
                            'action' => 'index'
                ));
            }
            return array('form' => $form, 'idCaracteristica' => $id);
        }
    }

    public function editAction() {
        var_dump("hola care bola");
        exit();
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
