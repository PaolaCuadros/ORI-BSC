<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonMode;
use Admin\Model\Admin;
use Admin\Form\AdminForm;

class AdminController extends AbstractActionController {

    protected $adminTable;
    protected $loginTable;

    public function indexAction() {
        $admin = $this->getAdminTable()->fetchAll();

        return array('admin' => $admin);
    }
    
    /*
     * Función para insertar datos a la tabla admin
     * $param $_POST['email'] => correo agergado por el administrador
     * $param $_POST['contrasena'] => contrasena agergada por el administrador
     * $param $_POST['contrasena'] => contrasena agergada por el administrador
     *      
     */
    
    public function addAction() {
        if ((isset($_POST['email'])) && (isset($_POST['contrasena']))) {
            $this->getLoginTable()->saveLogin($_POST['email'], $_POST['contrasena']);
            $idLogin = $this->getLoginTable()->getIdLogin($_POST['email']);
            foreach ($idLogin as $idLog) {
                $idUser = $idLog->ID_USUARIO;
            }
        }

        $form = new AdminForm();
        $request = $this->getRequest();
        if ($request->isPost()) {

            $admin = new Admin();
            $form->setInputFilter($admin->getInputFilter());
            $form->setData($request->getPost());
            $data = array();
            $admin->exchangeArray($data);
            $this->getAdminTable()->saveAdmin($admin, $idUser);

            return $this->redirect()->toRoute('admin', array(
                        'action' => 'index'
            ));
        }
    }
    
    
    /*
     * Función para editar datos a la tabla admin
     * $param $id o $_POST['id'] => id del administrador al cual se esta editando
     * Todos los datos $_POST son recogidos desde el formulario.
     *      
     */
    
    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }
        $admin = $this->getAdminTable()->getAdmin($id);

        $form = new AdminForm();
        $form->bind($admin);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $admin = new Admin();
            $form->setInputFilter($admin->getInputFilter());
            //var_dump($_POST['id']); exit();
            $data = array(
                'NOMBRE' => $_POST['name'],
                'ID_USUARIO' => $_POST['id'],
                'APELLIDO' => $_POST['apellido'],
                'DIRECCION' => $_POST['direccion'],
                'TELEFONO' => $_POST['telefono'],
                'CELULAR' => $_POST['celular']
            );


            $admin->exchangeArray($data);
            $this->getAdminTable()->saveAdmin($admin, 0);

            return $this->redirect()->toRoute('admin');
        } else {
            $admin = $this->getAdminTable()->getAdminId($id);
            return array('admin' => $admin);
        }
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            //var_dump($del); exit();
            if ($del == "Yes") {
                $id = (int) $request->getPost('id');
                $this->getAdminTable()->deleteAdmin($id);
            }
            return $this->redirect()->toRoute('admin');
        } else {
            return array(
                'id' => $id,
                'admin' => $this->getAdminTable()->getAdmin($id)
            );
        }
    }

    public function getAdminTable() {
        if (!$this->adminTable) {
            $sm = $this->getServiceLocator();
            $this->adminTable = $sm->get('Admin\Model\AdminTable');
        }
        return $this->adminTable;
    }

    public function getLoginTable() {
        if (!$this->loginTable) {
            $sm = $this->getServiceLocator();
            $this->loginTable = $sm->get('Login\Model\LoginTable');
        }
        return $this->loginTable;
    }

}
