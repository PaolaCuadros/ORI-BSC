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
    
    public function fetchAll($id){
        $resultSet = $this->select(array('idCaracteristica' => $id));
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
        
        $id = (int) $presupuestado->id;
        if($id == 0){
            $this->insert($data);
        }else{
            if($this->getPresupuestado($id)){
                $this->update($data, array('id' => $id));
            }else{
                throw new \Exception('Form id does not exist');
            }
        }
        
        
        //$this->insert($data);
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
    
    public function getSumPresupuestado($id, $date, $componente, $Idcaracte = null){
        //var_dump($Idcaracte);  exit();
        if($Idcaracte != null){
            //var_dump("aca"); exit();
            $sumPresupuestado = 'SELECT 
(SELECT SUM(presu.semestreA) FROM presupuestado AS presu INNER JOIN caracteristica AS carac ON presu.idCaracteristica = carac.ID INNER JOIN factores AS fact ON fact.id = carac.id_factor AND LEFT(presu.date, 4) = "'.$date.'" AND fact.id = '.$id.' AND carac.ID = '.$Idcaracte.') AS semestreaa,
(SELECT SUM(presu.semestreB) FROM presupuestado AS presu INNER JOIN caracteristica AS carac ON presu.idCaracteristica = carac.ID INNER JOIN factores AS fact ON fact.id = carac.id_factor AND LEFT(presu.date, 4) = "'.$date.'" AND fact.id = '.$id.' AND carac.ID = '.$Idcaracte.' ) AS semestrebb
FROM factores AS facto WHERE facto.id = '.$id.'';
        }else if($componente == 5){
            //var_dump("aca"); exit();
          $sumPresupuestado =  'SELECT (SELECT SUM(presu.semestreA) as summaa FROM componentes AS compo INNER JOIN factores AS fact ON compo.ID = fact.idParent INNER JOIN caracteristica AS caract ON caract.id_factor = fact.ID INNER JOIN presupuestado AS presu ON presu.idCaracteristica = caract.ID WHERE compo.ID = '.$componente.' AND LEFT(presu.date, 4) = "2015") AS semestreaa, (SELECT SUM(presu.semestreb) as summbb FROM componentes AS compo INNER JOIN factores AS fact ON compo.ID = fact.idParent INNER JOIN caracteristica AS caract ON caract.id_factor = fact.ID INNER JOIN presupuestado AS presu ON presu.idCaracteristica = caract.ID WHERE compo.ID = '.$componente.' AND LEFT(presu.date, 4) = "2015") AS semestrebb FROM componentes AS com WHERE com.ID = '.$componente.'';
        }else{
            $sumPresupuestado = 'SELECT (SELECT sum(presa.semestreA) as summaa FROM presupuestado AS presa INNER JOIN caracteristica as caracte on presa.idCaracteristica = caracte.ID INNER JOIN factores as fact ON fact.id = caracte.id_factor AND fact.id='.$id.' WHERE LEFT(presa.date, 4) = "'.$date.'") as semestreaa, (SELECT sum(presb.semestreB) as summbb FROM presupuestado AS presb INNER JOIN caracteristica as caracte on presb.idCaracteristica = caracte.ID INNER JOIN factores as fact ON fact.id = caracte.id_factor AND fact.id='.$id.' WHERE LEFT(presb.date, 4) = "'.$date.'") as semestrebb FROM presupuestado as tipm INNER JOIN caracteristica as caracte on tipm.idCaracteristica = caracte.ID INNER JOIN factores as fact ON fact.id = caracte.id_factor AND fact.id='.$id.' LIMIT 1';
        }
        $results = $this->adapter->query($sumPresupuestado, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }
    
    public function getPresupuestadoId($id){
        $sql = 'SELECT * FROM presupuestado WHERE id = "' . $id . '"';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }
    
    public function getPresupuestado($id){
        //var_dump($id); exit();
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    public function getSumpresupuestadoCaracteristica($idCaracteristica, $date){
        $sumEjecutadoCaracteristica = 'SELECT 
            (SELECT SUM(tipoa.semestreA) 
             FROM presupuestado AS tipoa  
             INNER JOIN caracteristica as caracte on tipoa.idCaracteristica = caracte.ID  AND caracte.ID= '.$idCaracteristica.'
             WHERE LEFT(tipoa.date, 4) = "'.$date.'") as semestreaa, 
                (SELECT SUM(tipob.semestreB) 
             FROM presupuestado AS tipob  
             INNER JOIN caracteristica as caracte on tipob.idCaracteristica = caracte.ID  AND caracte.ID= '.$idCaracteristica.'
             WHERE LEFT(tipob.date, 4) = "'.$date.'")as semestrebb
        FROM presupuestado as tipm 
        INNER JOIN caracteristica as caracte on tipm.idCaracteristica = caracte.ID  AND caracte.ID = '.$idCaracteristica.'
        LIMIT 1';
        $result = $this->adapter->query($sumEjecutadoCaracteristica, Adapter::QUERY_MODE_EXECUTE);
        return $result;
    }
    

}

