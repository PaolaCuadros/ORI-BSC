<?php

namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Mail\Message;
use Zend\Mail\Transport\File as FileTransport;
use Zend\Mail\Transport\FileOptions;
use Zend\Mail\Transport\InMemory as InMemoryTransport;
use Zend\Mail\Transport\Sendmail as SendmailTransport;

class AdminTable extends AbstractTableGateway {

    protected $table = "admin";

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Admin());
        $this->initialize();
    }

    public function fetchAll() {
        $sql = "SELECT log.ID_USUARIO as id, EMAIL as email, NOMBRE as nombre, APELLIDO as apellido, DIRECCION as direccion, TELEFONO as telefono, CELULAR as celular FROM login as log INNER JOIN admin AS admin ON log.ID_USUARIO = admin.ID_USUARIO";
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }

    public function saveAdmin(Admin $admin, $idUser) {
        $data = array(
            'ID_USUARIO' => $idUser,
            'NOMBRE' => $_POST['name'],
            'APELLIDO' => $_POST['apellido'],
            'DIRECCION' => $_POST['direccion'],
            'TELEFONO' => $_POST['telefono'],
            'CELULAR' => $_POST['celular'],
        );

        if (isset($_POST['id']))
            $id = (int) $_POST['id'];

        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getAdmin($id)) {
                $sql = 'UPDATE admin SET NOMBRE = "'.$_POST['name'].'", APELLIDO = "'.$_POST['apellido'].'", DIRECCION = "'.$_POST['direccion'].'", TELEFONO = "'.$_POST['telefono'].'", CELULAR = "'.$_POST['celular'].'" WHERE ID_USUARIO = "'.$id.'" ';
                $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
            }
        }

    }

    public function getAdmin($id) {
        $id = (int) $id;
        $rowset = $this->select(array('ID_USUARIO' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("pailas");
        }
        return $row;
    }

    public function getAdminId($id) {
        $sql = 'SELECT log.ID_USUARIO as id, EMAIL as email, NOMBRE as nombre, APELLIDO as apellido, DIRECCION as direccion, TELEFONO as telefono, CELULAR as celular FROM login as log INNER JOIN admin AS admin ON log.ID_USUARIO = admin.ID_USUARIO WHERE log.ID_USUARIO = "' . $id . '" ';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }
    
    public function deleteAdmin($id){
        //var_dump("aca"); exit();
        $sql = 'UPDATE admin SET ESTADO = "I" WHERE ID_USUARIO = "'.$id.'" ';
                $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
    }
    
    public function getNameAdmin($id){
        $sql = 'SELECT NOMBRE FROM admin WHERE ID_USUARIO = "' . $id . '" ';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }

}
