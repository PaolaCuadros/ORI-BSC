<?php

namespace Caracteristica\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class CaracteristicaTable extends AbstractTableGateway {
    
    protected $table ='caracteristica';
    
    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Caracteristica());
        $this->initialize();
    }
    
    public function fetchAll(){
        $resultSet = $this->select();
        return $resultSet;
    }
    
    public function getCaracteristicaFactor($id, $idComponente) {
//        $sql = 'SELECT * FROM caracteristica WHERE id_factor = "' . $id . '"';
        if($idComponente == 0){
            $sql = 'select * FROM caracteristica as caracte 
INNER JOIN factores AS fact ON caracte.id_factor = fact.id 
INNER JOIN componentes AS comp ON comp.id = fact.idParent
WHERE caracte.id_factor =  "' . $id . '"';
        }else{
            $sql = 'select * FROM caracteristica as caracte 
INNER JOIN factores AS fact ON caracte.id_factor = fact.id 
INNER JOIN componentes AS comp ON comp.id = fact.idParent
WHERE caracte.id_factor =  "' . $id . '" AND comp.id = "' . $idComponente . '" ';
        }
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
        
        
        /*if($idComponente == 0){
            $sql = 'select * FROM caracteristica as caracte 
INNER JOIN factores AS fact ON caracte.id_factor = fact.id 
INNER JOIN componentes AS comp ON comp.id = fact.idParent
WHERE caracte.id_factor =  "' . $id . '"';
        }else{
            $sql = 'select * FROM caracteristica as caracte 
INNER JOIN factores AS fact ON caracte.id_factor = fact.id 
INNER JOIN componentes AS comp ON comp.id = fact.idParent
WHERE caracte.id_factor =  "' . $id . '" AND comp.id = "' . $idComponente . '" ';
        }*/
    }

    public function getCaracteristica($id){
        //var_dump($id); exit();
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    public function saveCaracteristica(Caracteristica $caracteristica){
        //var_dump($caracteristica); exit();
        $data = array(
            'caracteristica' => $caracteristica->caracteristica,
            'date_creation' => $caracteristica->date_creation,
            'id_factor' => $caracteristica->id_factor,
        );
        
        $id = (int) $caracteristica->id;
        if($id == 0){
            $this->insert($data);
        }else{
            if($this->getCaracteristica($id)){
                $this->update($data, array('id' => $id));
            }else{
                throw new \Exception('Form id does not exist');
            }
        }
    }
    
    public function editCaracteristica($id){
       // var_dump("asas"); var_dump($id); exit();
        $resultSet = $this->select(array('id' => $id));
        return $resultSet;
    }
    
    public function deleteCaracteristica($id){
        $this->delete(array('id' => $id));
    }
    
    public function getCaracteristicaId($id){
        $sql = 'SELECT id_factor, CARACTERISTICA FROM caracteristica WHERE id = "'.$id.'"';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }
    
    
}

