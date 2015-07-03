<?php

namespace Presupuestado\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class PresupuestadoTable extends AbstractTableGateway {
    protected $table = 'presupuestado';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Presupuestado());
        $this->initialize();
    }
    
    public function fetchAll(){
        $resultSet = $this->select();
        return $resultSet;
    }
    
    public function savePresupuestado(Presupuestado $presupuestado){
        //var_dump("aca llega..."); var_dump($presupuestado->date); exit();
        $data = array(
            'date' => $presupuestado->date,
            'semestreA' => $presupuestado->semestreA,
            'semestreB' => $presupuestado->semestreB,
            'idCaracteristica' => $presupuestado->idCaracteristica,
        );
        
        $this->insert($data);
    }
    
    public function addPresupuesto(){
        $sql = 'SELECT ID FROM caracteristica  ORDER BY ID DESC LIMIT 1';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        foreach ($results as $idCaracteristica){
            $id = $idCaracteristica->ID;
        }
        return $id;
    }
    
    public function getPresupuestadoCaracteristica($id) {
        $sql = 'SELECT * FROM presupuestado WHERE idCaracteristica = "' . $id . '"';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }
    
    public function getDatePresupuestado(){
        $sql = "SELECT DISTINCT date as fecha FROM presupuestado";
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }
    
    public function getSumPresupuestado($id, $date){
        $sumPresupuestado = 'SELECT (SELECT sum(presa.semestreA) as summaa FROM presupuestado AS presa INNER JOIN caracteristica as caracte on presa.idCaracteristica = caracte.ID INNER JOIN factores as fact ON fact.id = caracte.id_factor AND fact.id='.$id.' WHERE LEFT(presa.date, 4) = "'.$date.'") as semestreaa, (SELECT sum(presb.semestreB) as summbb FROM presupuestado AS presb INNER JOIN caracteristica as caracte on presb.idCaracteristica = caracte.ID INNER JOIN factores as fact ON fact.id = caracte.id_factor AND fact.id='.$id.' WHERE LEFT(presb.date, 4) = "'.$date.'") as semestrebb FROM presupuestado as tipm INNER JOIN caracteristica as caracte on tipm.idCaracteristica = caracte.ID INNER JOIN factores as fact ON fact.id = caracte.id_factor AND fact.id='.$id.' LIMIT 1';
        $results = $this->adapter->query($sumPresupuestado, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }
    

}

