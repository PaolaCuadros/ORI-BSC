<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonMode;
use Usuarios\Model\Usuarios;
use Usuarios\Form\UsuariosForm;

class UsuariosController extends AbstractActionController {

    protected $usuariosTable;

    public function indexAction() {
        return new ViewModel(array(
            'usuarios' => $this->getUsuariosTable()->fetchAll(),
        ));
    }

    public function addAction() {
        $progAcademico = $this->getUsuariosTable();
        $progInteres = $this->getUsuariosTable();

        $idUsuario = $this->params()->fromRoute('id', 0);

        $form = new UsuariosForm();
        $request = $this->getRequest();

        if ($request->isPost()) {

            $usuarios = new Usuarios();
            $form->setInputFilter($usuarios->getInputFilter());
            $form->setData($request->getPost());

            $data = array();

            $usuarios->exchangeArray($data);
            $this->getUsuariosTable()->saveUsuario($usuarios);

            return $this->redirect()->toRoute('usuarios', array(
                        'action' => 'index'
            ));
        } else {
            return array('form' => $form, 'progAcademico' => $progAcademico, 'progInteres' => $progInteres);
        }
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }

        $usuarios = $this->getUsuariosTable()->getUsuario($id);

        $form = new UsuariosForm();
        
        $form->bind($usuarios);
        
//        $form->get('submit')->setAttribute('value', 'Edit');
//        var_dump("aca"); exit();
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $usuarios = new Usuarios();
            $form->setInputFilter($usuarios->getInputFilter());
            $form->setData($request->getPost());

            $data = array(
                'NOMBRE' => $_POST['name'],
                'APELLIDO' => $_POST['last_name'],
                'EMAIL' => $_POST['email'],
                'TELEFONO' => $_POST['telefono'],
                'CODIGO_ESTUDIANTIL' => $_POST['cod_estud'],
                'ID_CARRERA' => $_POST['prog_academic'],
                'SEMESTRE' => $_POST['semestre'],
                'PROINTERES' => $_POST['prog_interes'],
                'COMPROMISOS' => $_POST['compromisos'],
                'OBSERVACIONES' => $_POST['observaciones'],
            );

            $usuarios->exchangeArray($data);
            $this->getUsuariosTable()->saveUsuario($usuarios);

            return $this->redirect()->toRoute('usuarios');
        } else {
            $progAcademico = $this->getUsuariosTable();
            $progInteres = $this->getUsuariosTable();
            $usuarios = $this->getUsuariosTable($id)->getAllUsuarios($id);

            foreach ($usuarios as $usuario) {
                $id = $usuario->id;
                $cod_estud = $usuario->cod_estud;
                $nombre = $usuario->nombre;
                $last_name = $usuario->last_name;
                $telefono = $usuario->telefono;
                $carrera = $usuario->carrera;
                $compromisos = $usuario->compromisos;
                $observaciones = $usuario->observaciones;
                $prog_interes = $usuario->prog_interes;
                $semestre = $usuario->semestre;
                $email = $usuario->email;
            }
            return array(
                'id' => $id,
                'cod_estud' => $cod_estud,
                'nombre' => $nombre,
                'last_name' => $last_name,
                'telefono' => $telefono,
                'carrera' => $carrera,
                'compromisos' => $compromisos,
                'observaciones' => $observaciones,
                'prog_interes' => $prog_interes,
                'semestre' => $semestre,
                'email' => $email, 'progAcademico' => $progAcademico, 'progInteres' => $progInteres
            );
        }
    }

    public function deleteAction() {
        
    }

    public function getUsuariosTable() {
        if (!$this->usuariosTable) {
            $sm = $this->getServiceLocator();
            $this->usuariosTable = $sm->get('Usuarios\Model\UsuariosTable');
        }
        return $this->usuariosTable;
    }
    
    public function ejecutadoAction() {
//        var_dump("ca"); exit();
//        $componentes = $this->getPreComponentesTable()->fetchAll();
//        $factores = $this->getPreFactoresTable();
//        $caracteristicas = $this->getPreCaracteristicasTable();
//        $presupuestado = $this->getUsuariosTable();
//        return array (
//            'componentes' => $componentes,
//            'factores' => $factores,
//            'caracteristicas' => $caracteristicas,
//            'presupuestado' => $presupuestado
//        );
    }

}
