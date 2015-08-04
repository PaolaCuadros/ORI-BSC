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
    protected $observacionesTable;

    public function indexAction() {
        if (isset($_SESSION['user'])) {
            return new ViewModel(array(
                'usuarios' => $this->getUsuariosTable()->fetchAll(),
            ));
        } else {
            $this->redirect()->toRoute('login', array('action' => 'login'));
        }
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

//            if (isset($_POST['idobservaM'])) {
//                var_dump($_POST['idobservaM']); exit();
//                $this->getObservacionesTable()->updateObservaciones($_POST['observaM'], $_POST['idobservaM']);
//            }

            if (isset($_POST['observa'])) {
                $this->getObservacionesTable()->updateObservaciones($_POST['observa'], $_POST['id']);
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
            $observacionesUsuario = $this->getObservacionesTable();

            foreach ($usuarios as $usuario) {
                
            //var_dump($usuario); exit();
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
                $fechaCompromiso = $usuario->fechaCompromiso;
                $celular = $usuario->celular;
                $otro_email = $usuario->otroemail;
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
                'email' => $email, 'progAcademico' => $progAcademico, 'progInteres' => $progInteres, 'estado' => $estado, 'observacionesUsuario' => $observacionesUsuario, 'otro_prog_interes' => $otro_prog_interes, 'fechaCompromiso' => $fechaCompromiso, 'otro_email' => $otro_email,  'celular' => $celular
            );
        }
    }

    public function deleteAction() {
        
    }

    public function sendEmailAction() {
        $dateActual = date("Y/m/d");
        $dayActual = date("d");
        $dayActual1 = $dayActual + 5;
        $dateNext = date("Y/m");
        $day = $dateNext . "/" . $dayActual1;
        $getUsuariosCompromisos = $this->getUsuariosTable()->getDateCommitmentUser($dateActual, $day);
        $html = "
            <p FACE='arial'>Buenos días Administrador <br/><br/>
            La siguiente es la información de los compormisos con los estudiantes interesados en relizar una movilidad:<p>

            <html>
                    <head>
                        <title>Compromisos ORI</title>
                    </head>
                    <body>
                    <table border='1' WIDTH='900'>
                        <tr>
                            <td bgcolor='A9E2F3' align='center' color='F2F2F2' SIZE=8><b>Estudiante</b></td>
                            <td bgcolor='A9E2F3' align='center' color='F2F2F2' SIZE=3><b>Codigo Estudiantil</b></td>
                            <td bgcolor='A9E2F3' align='center' color='F2F2F2' SIZE=3><b>Compromiso</b></td>
                            <td bgcolor='A9E2F3' align='center' color='F2F2F2'><b>Fecha de Compromiso</b></td>
                        </tr>";
        foreach ($getUsuariosCompromisos as $usuario) {
            $html .= "
                        <tr>
                            <td>" . $usuario->NOMBRE . "  " . $usuario->APELLIDO . "</td>
                            <td>" . $usuario->CODIGO_ESTUDIANTIL . "</td>
                            <td>" . $usuario->FECHACOMPROMISO . "</td>
                                <td>" . $usuario->COMPROMISOS . "</td>
                        </tr>";
        }
        $html .= "  </table>
                    </body>
            </html> <br/> Feliz día <br/><br/><br/>
            
            <b> Oficina de Relaciones Internacionales. </b> <br/>
            <b> Universidad de Ibagué </b> <br/><br/>
            <img src='https://ci3.googleusercontent.com/proxy/5Age9PF7_IRDkg8IFsp_gzSPiXGbJwBiNDaZsMQM_ynwhaEmrgV1IX7482lM905C-_oKsPCZLja_3Ugb0ONiCmLDn2FCe67zWEBr3SqDWdqGejbvHPGGfXUFM8vNoXelxB2cAPFGF6W965QegB-JA7F3kCYtDBkxXV8TUM0AnXXZ5pO4DB8q9KDU2jNF4Y4ZgJ3NHFXIge_TDe4=s0-d-e1-ft#https://docs.google.com/uc?export=download&id=0B4akwvlP8hRSNF80eW9JWUJmSDQ&revid=0B4akwvlP8hRSQTRXNzEzKzZtWFlCQzN1Ukd5bDRoWjI0Z3ZVPQ' width='250'  height='120'/>

            ";
        $sendEmailUser = $this->getUsuariosTable()->sendEmail($html);
        if($sendEmailUser){
            Echo "Envio exitoso";
        }
    }

    public function getUsuariosTable() {
        if (!$this->usuariosTable) {
            $sm = $this->getServiceLocator();
            $this->usuariosTable = $sm->get('Usuarios\Model\UsuariosTable');
        }
        return $this->usuariosTable;
    }
    
    
    public function getObservacionesTable() {
        if (!$this->observacionesTable) {
            $sm = $this->getServiceLocator();
            $this->observacionesTable = $sm->get('Observaciones\Model\ObservacionesTable');
        }
        return $this->observacionesTable;
    }

}
