<?php
namespace Login\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class LoginTable extends AbstractTableGateway {
    protected $table ='login';
    
    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Login());
        $this->initialize();
    }
    
    public function fetchAll($id){
        $sql = "SELECT EMAIL FROM login WHERE ID_USUARIO = '".$id."'";
        $resultSet = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
    }
    
    public function loginUser($email, $pass){
        $sql = 'SELECT * FROM login WHERE EMAIL="'.$email.'" AND CONTRASENA= MD5("'.$pass.'")';
        $resultSet = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
    }
    
    public function saveLogin($email, $pass){
        $sql = "INSERT INTO login (EMAIL, CONTRASENA) VALUES ('".$email."', MD5(".$pass."))";
        $resultSet = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
    }
    
    public function getIdLogin($email){
        $sql = "SELECT ID_USUARIO FROM login WHERE EMAIL = '".$email."'";
        $resultSet = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
    }
    
}

