<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonMode;
use Usuarios\Model\Usuarios;
use Usuarios\Form\UsuariosForm;

class UsuariosController extends AbstractActionController {

    protected $usuariosTable;
    
    protected $preComponentesTable;
    protected $preFactoresTable;
    protected $preCaracteristicasTable;

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
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $usuarios = new Usuarios();
            $form->setInputFilter($usuarios->getInputFilter());
            $form->setData($request->getPost());
            
            if(isset($_POST['idobservaM'])){
                $this->getUsuariosTable()->updateObservaciones($_POST['observaM'], $_POST['idobservaM']);
            }

            if(isset($_POST['observa'])){
                $this->getUsuariosTable()->saveObservaciones($_POST['observa'], $_POST['id']);
            }

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
                'ESTADO' => $_POST['estado'],
            );

            $usuarios->exchangeArray($data);
            $this->getUsuariosTable()->saveUsuario($usuarios);

            return $this->redirect()->toRoute('usuarios');
        } else {
            $progAcademico = $this->getUsuariosTable();
            $progInteres = $this->getUsuariosTable();
            $usuarios = $this->getUsuariosTable($id)->getAllUsuarios($id);
            $observacionesUsuario = $this->getUsuariosTable();

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
                $estado = $usuario->estado;
                $otro_prog_interes = $usuario->otro_prog_interes;
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
                'email' => $email, 'progAcademico' => $progAcademico, 'progInteres' => $progInteres, 'estado' => $estado,  'observacionesUsuario' => $observacionesUsuario, 'otro_prog_interes' => $otro_prog_interes
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
    
//    public function getPreComponentesTable() {
//        if (!$this->preComponentesTable) {
//            $sm = $this->getServiceLocator();
//            $this->preComponentesTable = $sm->get('Componentes\Model\ComponentesTable');
//        }
//        return $this->preComponentesTable;
//    }
//    
//    public function getPreFactoresTable() {
//        if (!$this->preFactoresTable) {
//            $sm = $this->getServiceLocator();
//            $this->preFactoresTable = $sm->get('Factores\Model\FactoresTable');
//        }
//        return $this->preFactoresTable;
//    }
//    
//    public function getPreCaracteristicasTable() {
//        if (!$this->preCaracteristicasTable) {
//            $sm = $this->getServiceLocator();
//            $this->preCaracteristicasTable = $sm->get('Caracteristica\Model\CaracteristicaTable');
//        }
//        return $this->preCaracteristicasTable;
//    }
//    
//    public function ejecutadoAction() {
//        $componentes = $this->getPreComponentesTable()->fetchAll();
//        $factores = $this->getPreFactoresTable();
//        $caracteristicas = $this->getPreCaracteristicasTable();
//        $ejecutado = $this->getUsuariosTable();
//        return array (
//            'componentes' => $componentes,
//            'factores' => $factores,
//            'caracteristicas' => $caracteristicas,
//            'ejecutado' => $ejecutado
//        );
//    }

}
