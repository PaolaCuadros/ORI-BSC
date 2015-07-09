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
    
    public function fetchAll(){
        
    }
    
    public function loginUser($email, $pass){
        //var_dump("aca"); exit();//SELECT * FROM `login` WHERE CONTRASENA = MD5("123456")
        $sql = 'SELECT * FROM login WHERE EMAIL="'.$email.'" AND CONTRASENA= MD5("'.$pass.'") ';
        $resultSet = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
    }
}

