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

            if (isset($_POST['idobservaM'])) {
                $this->getUsuariosTable()->updateObservaciones($_POST['observaM'], $_POST['idobservaM']);
            }

            if (isset($_POST['observa'])) {
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
                'email' => $email, 'progAcademico' => $progAcademico, 'progInteres' => $progInteres, 'estado' => $estado, 'observacionesUsuario' => $observacionesUsuario, 'otro_prog_interes' => $otro_prog_interes
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
        $html = "<html>
                    <head>
                        <title>Compromisos ORI</title>
                    </head>
                    <body>
                    <table border='1'>
                        <tr>
                            <td bgcolor='A9E2F3' align='center' color='F2F2F2'>Estudiante</td>
                            <td bgcolor='A9E2F3' align='center' color='F2F2F2'>Codigo Estudiantil</td>
                            <td bgcolor='A9E2F3' align='center' color='F2F2F2'>Fecha de Compromiso</td>
                        </tr>";
        foreach ($getUsuariosCompromisos as $usuario) {
            $html .= "
                        <tr>
                            <td>" . $usuario->NOMBRE . "  "  . $usuario->APELLIDO . "</td>
                            <td>" . $usuario->CODIGO_ESTUDIANTIL . "</td>
                            <td>" . $usuario->FECHACOMPROMISO . "</td>
                        </tr>";
        }
        $html .= "  </table>
                    </body>
                </html>";



//        $mensaje = '
//<html>
//<head>
//  <title>Recordatorio de cumpleaños para Agosto</title>
//</head>
//<body>
//  <p>¡Estos son los cumpleaños para Agosto!</p>
//  <table>
//    <tr>
//      <th>Quien</th><th>Día</th><th>Mes</th><th>Año</th>
//    </tr>
//    <tr>
//      <td>Joe</td><td>3</td><td>Agosto</td><td>1970</td>
//    </tr>
//    <tr>
//      <td>Sally</td><td>17</td><td>Agosto</td><td>1973</td>
//    </tr>
//  </table>
//</body>
//</html>
//';

        $sendEmailUser = $this->getUsuariosTable()->sendEmail($html);
    }

    public function getUsuariosTable() {
        if (!$this->usuariosTable) {
            $sm = $this->getServiceLocator();
            $this->usuariosTable = $sm->get('Usuarios\Model\UsuariosTable');
        }
        return $this->usuariosTable;
    }

}
