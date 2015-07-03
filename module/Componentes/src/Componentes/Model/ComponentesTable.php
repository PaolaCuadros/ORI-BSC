<?php

namespace Componentes\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class ComponentesTable extends AbstractTableGateway {

    protected $table = 'componentes';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Componentes());
        $this->initialize();
    }

    public function fetchAll() {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function saveComponente(Componentes $componente) {
        $data = array(
            'name' => $componente->name,
        );
        $id = (int) $componente->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getComponente($id)) {
                $this->update($data, array('id' => $id));
            }
        }
    }

    public function getComponente($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("pailas");
        }
        return $row;
    }

    public function getAllComponentes($id) {
        $resultSet = $this->select(array('id' => $id));
        return $resultSet;
    }

    public function deleteComponente($id) {
        $this->delete(array('id' => $id));
    }

    public function getPdiPresupuestado() {
        $sql = 'SELECT * FROM caracteristica WHERE id_factor = "' . $id . '"';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }

    public function getOneComponente($limit) {
        $sql = 'SELECT id, name FROM componentes limit ' . $limit . '';
        $resultSet = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
    }
    
    public function getIndicadores(){
        $sql = 'SELECT ID, NAME FROM indicadores WHERE ID_PARENT=0  ';
        $resultSet = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
    }
    
    public function getSubIndicadores($id){
        $sql = 'SELECT ID, NAME, ID_FACTOR FROM indicadores WHERE ID_PARENT='.$id.'';
        //VAR_DUMP($sql); 
        $resultSet = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
    }
    
    public function getFactorDiuff(){
        $sql = 'SELECT id, name FROM componentes WHERE id <> 1';
        //VAR_DUMP($sql); 
        $resultSet = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
    }

}
