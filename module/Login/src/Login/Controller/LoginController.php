<?php

namespace Login\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Login\Model\Login;          // <-- Add this import
use Login\Form\LoginForm;       // <-- Add this import
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

//use Zend\Authentication\Storage\Session;

class LoginController extends AbstractActionController {

    protected $loginTable;

    public function indexAction() {
        $session = new Container('user');
        $session->getManager()->destroy();
        $this->redirect()->toRoute('login', array('action' => 'login'));
    }

    public function loginAction() {

        if (isset($_SESSION['user'])) {
            $this->redirect()->toRoute('usuarios', array('action' => 'index'));
        } else {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $login = $this->getLoginTable()->loginUser($_POST['nombre'], $_POST['password']);
                foreach ($login as $getLogin) {
                    //var_dump($getLogin);
                    $email = $getLogin->EMAIL;
                    $passw = $getLogin->CONTRASENA;
                    $permi = $getLogin->ESTADO;
                    $idUsu = $getLogin->ID_USUARIO;
                } //exit();
                if ((isset($email) && ($permi == "A"))) {

                    $_SESSION['user'] = $idUsu;

                    $this->redirect()->toRoute('usuarios', array('action' => 'index'));
                } else {
                    if ((isset($permi)) && ($permi == "I")) {
                        $msj = 1;
                    } else {
                        $msj = 2;
                    }

                    return array(
                        'msj' => $msj
                    );
                }
            }
        }
    }

    public function getLoginTable() {
        if (!$this->loginTable) {
            $sm = $this->getServiceLocator();
            $this->loginTable = $sm->get('Login\Model\LoginTable');
        }
        return $this->loginTable;
    }

}
