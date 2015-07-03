<?php

namespace Ejecutado\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class EjecutadoTable extends AbstractTableGateway {
    
    protected $table = "ejecutado";
    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Ejecutado());
        $this->initialize();
    }
    
    public function fetchAll(){
        $resultSet = $this->select();
        return $resultSet;
    }
    
    public function saveEjecutado(Ejecutado $ejecutado, $url){
        $id = 0;
        $data = array(
            'ANIO' => $_POST['anio'],
            'SEMESTRE' => $_POST['semestre'],
            'CALIFICACION' => $_POST['calificacion'],
            'URL' => $url,
            'IDCARACTERISTICA' => $_POST['idCaracteristica']
        );
        if (isset($_POST['id']))
            $id = (int) $_POST['id'];
        if ($id == 0) {
            $this->insert($data);
        } 
    }
    
    public function getEjecutadoCaracteristica($id){
        $resultSet = $this->select(array('IDCARACTERISTICA' => $id));
        //var_dump($resultSet); exit();
        return $resultSet;
    }
}

