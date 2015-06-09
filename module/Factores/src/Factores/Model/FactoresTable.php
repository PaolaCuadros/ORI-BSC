<?php
namespace Factores\Model;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class FactoresTable extends AbstractTableGateway {
    protected $table ='factores';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Factores());
        $this->initialize();
    }
    
    public function fetchAll(){
        $resultSet = $this->select(array('idParent' => 0));
        return $resultSet;
    }

    public function getFactores($id){
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    public function saveFactores(Factores $factores){
        $descripcion = "";
        $idParent = 0;
        if(isset($factores->descripcion) && $factores->descripcion != ""){
            $descripcion = $factores->descripcion;
        }  
        
        if(isset($factores->idParent) && $factores->idParent >= 1){

            $idParent = $factores->idParent;
        }  
//        var_dump($idParent); exit();
        //
        $data = array(
            'name' => $factores->name,
            'idParent' => $idParent,
//            'descripcion' => $descripcion,
            
        );
        
        //var_dump($data); exit();
        $id = (int)$factores->id;
        if ($id == 0) {
            $this->insert($data);
            
        } else {
            if ($this->getFactores($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    
    public function deleteFactores($id){
        $this->delete(array('id' => $id));
    }
    
    public function itemsFactores($id){
        $resultSet = $this->select(array('idParent' => $id));
        return $resultSet;
    }
}

