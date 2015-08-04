<?php

namespace Observaciones\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonMode;
use Observaciones\Model\Observaciones;

//use Observaciones\Form\ObservacionesForm;

class ObservacionesController extends AbstractActionController {

    protected $observacionesTable;
    protected $usuariosTable;

    public function indexAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $getAllObservacionesUser = $this->getObservacionesTable();
        $getUsuarioObservaciones = $this->getUsuariosTable()->getUsuarioObservaciones($id);
        foreach ($getUsuarioObservaciones as $nameUsuario){
            $nombreUsuario = $nameUsuario->NOMBRE . " " . $nameUsuario->APELLIDO;
        }

        return array(
            'getAllObservacionesUser' => $getAllObservacionesUser,
            'id' => $id,
            'nombreUsuario' => $nombreUsuario
        );
    }

    public function getObservacionesTable() {
        if (!$this->observacionesTable) {
            $sm = $this->getServiceLocator();
            $this->observacionesTable = $sm->get('Observaciones\Model\ObservacionesTable');
        }
        return $this->observacionesTable;
    }
    
    public function getUsuariosTable() {
        if (!$this->usuariosTable) {
            $sm = $this->getServiceLocator();
            $this->usuariosTable = $sm->get('Usuarios\Model\UsuariosTable');
        }
        return $this->usuariosTable;
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $request = $this->getRequest();

        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            if ($del == "Yes") {
                $id = (int) $request->getPost('id');
                $this->getObservacionesTable()->deleteObservacion($id);
                $isUser = $this->getObservacionesTable()->getUserObservacion($id);
                //var_dump($isUser);
                foreach ($isUser as $user) {
                    $isUser = $user->idUser;
                }
            }
            return $this->redirect()->toRoute('usuarios', array(
                        'action' => 'edit', 'id' => $isUser
            ));
        } else {
            return array(
                'id' => $id,
                'observacion' => $this->getObservacionesTable()->getIdObservacion($id)
            );
        }
    }

}
