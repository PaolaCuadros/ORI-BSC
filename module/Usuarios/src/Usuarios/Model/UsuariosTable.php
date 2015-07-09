<?php

namespace Usuarios\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class UsuariosTable extends AbstractTableGateway {

    protected $table = "usuario";

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Usuarios());
        $this->initialize();
    }

    public function fetchAll() {
        $sql = 'SELECT usu.ID as id, usu.CODIGO_ESTUDIANTIL as cod_estud, usu.NOMBRE as name, usu.APELLIDO as last_name, usu.TELEFONO as telefono, usu.SEMESTRE as semestre, proin.name as prog_interes, usu.COMPROMISOS as compromisos, usu.OBSERVACIONES as observaciones, usu.EMAIL as email, car.NOMBRE as carrera, usu.FECHA_CREACION, usu.ESTADO FROM usuario as usu INNER JOIN carrera as car on car.ID_CARRERA = usu.ID_CARRERA INNER JOIN programainteres AS proin on proin.id = usu.PROINTERES';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }

    public function saveUsuario(Usuarios $usuarios) {
        $id = 0;
        $data = array(
            'NOMBRE' => $_POST['name'],
            'APELLIDO' => $_POST['last_name'],
            'EMAIL' => $_POST['email'],
            'TELEFONO' => $_POST['telefono'],
            'CODIGO_ESTUDIANTIL' => $_POST['cod_estud'],
            'ID_CARRERA' => $_POST['prog_academic'],
            'SEMESTRE' => $_POST['semestre'],
            'PROINTERES' => $_POST['prog_interes'],
            'COMPROMISOS' => $_POST['compromisos'],
            'OBSERVACIONES' => $_POST['observaciones'],
            'ESTADO' => $_POST['estado'],
            'OTROPROGINTERES' => $_POST['otro_prog_interes'],
        );
        if (isset($_POST['id']))
            $id = (int) $_POST['id'];
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getUsuario($id)) {
                $this->update($data, array('id' => $id));
            }
        }
    }

    public function getAllProgramasAcademicos() {
        $sql = 'SELECT ID_CARRERA, NOMBRE FROM carrera ORDER BY NOMBRE ASC';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }

    public function getAllProgramasInteres() {
        $sql = 'SELECT id, name FROM programainteres ORDER BY id ASC';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }

    public function getAllUsuarios($id) {
        $resultSet = $this->select(array('id' => $id));
        return $resultSet;
    }

    public function getUsuario($id) {
        $id = (int) $id;
        //var_dump($id); exit();
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("pailas");
        }
        return $row;
    }

    public function getEjecutadoCaracteristica($id, $date) {
        //var_dump("aca"); exit();
        $sqlSemestreA = 'SELECT (SELECT COUNT(tipoa.SEMESTRE) FROM tipomovilidad AS tipoa WHERE tipoa.SEMESTRE = "A" and tipoa.idCaracteristica = "' . $id . '" and tipoa.ANIO = "' . $date . '") as semestreaa, (SELECT COUNT(tipo.SEMESTRE) FROM tipomovilidad AS tipo WHERE tipo.SEMESTRE = "B" and tipo.idCaracteristica = "' . $id . '" and tipo.ANIO = "' . $date . '") as semestrebb FROM tipomovilidad as tipm WHERE tipm.idCaracteristica = "' . $id . '" LIMIT 1';
        //var_dump($sqlSemestreA); echo "<br/>";

        $resultA = $this->adapter->query($sqlSemestreA, Adapter::QUERY_MODE_EXECUTE);
        //        $sqlSemestreB = 'SELECT COUNT(SEMESTREB) as semestreb FROM tipomovilidad WHERE SEMESTREB <> "" and idCaracteristica = "' . $id . '"';
//        
//        $resultB = $this->adapter->query($sqlSemestreB, Adapter::QUERY_MODE_EXECUTE);
//        //var_dump("aca ->"); var_dump($resultB); echo "<br/>"; exit();
        return $resultA;
    }

    public function getDateEjecutado() {
        $sql = "SELECT DISTINCT ANIO as fecha FROM tipomovilidad";
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }

    public function sumEjecutadoCaracteristica($id, $date, $componente) {
        if($componente == 5){
            $sqlSmestre = 'SELECT
(SELECT COUNT(ejecu.SEMESTRE) FROM ejecutado AS ejecu 
INNER JOIN caracteristica AS caract ON ejecu.IDCARACTERISTICA = caract.ID 
INNER JOIN factores AS fact ON caract.id_factor = fact.id 
INNER JOIN componentes AS comp ON comp.id = fact.idParent
WHERE comp.id = '.$componente.' AND ejecu.SEMESTRE = "A" AND ejecu.CALIFICACION >= "1" AND ejecu.ANIO = "' . $date . '") AS semestreaa,

(SELECT COUNT(ejecu.SEMESTRE) FROM ejecutado AS ejecu 
INNER JOIN caracteristica AS caract ON ejecu.IDCARACTERISTICA = caract.ID 
INNER JOIN factores AS fact ON caract.id_factor = fact.id 
INNER JOIN componentes AS comp ON comp.id = fact.idParent
WHERE comp.id = '.$componente.' AND ejecu.SEMESTRE = "B" AND ejecu.CALIFICACION >= "1" AND ejecu.ANIO = "' . $date . '") AS semestrebb

FROM componentes AS com WHERE com.ID = '.$componente.'';
        }else{
            $sqlSmestre = 'SELECT (SELECT COUNT(tipoa.SEMESTRE) FROM tipomovilidad AS tipoa INNER JOIN caracteristica as caracte on tipoa.idCaracteristica = caracte.ID INNER JOIN factores as fact ON fact.id = caracte.id_factor AND fact.id=' . $id . ' WHERE tipoa.SEMESTRE = "A" and tipoa.ANIO = "' . $date . '") as semestreaa, (SELECT COUNT(tipo.SEMESTRE) FROM tipomovilidad AS tipo INNER JOIN caracteristica as caracte on tipo.idCaracteristica = caracte.ID INNER JOIN factores as fact ON fact.id = caracte.id_factor AND fact.id=' . $id . ' WHERE tipo.SEMESTRE = "B" and tipo.ANIO = "' . $date . '") as semestrebb, fact.id FROM tipomovilidad as tipm INNER JOIN caracteristica as caracte on tipm.idCaracteristica = caracte.ID INNER JOIN factores as fact ON fact.id = caracte.id_factor AND fact.id=' . $id . ' limit 1';
        }
        
        
        
        //if($id != 15){
            
           // var_dump($sqlSmestre); 
//        }else{
//            
//        }

        

        //var_dump($sqlSmestre); exit();
//        $sqlSemestre = 'SELECT 
//(SELECT COUNT(tipoa.SEMESTRE) FROM tipomovilidad AS tipoa WHERE tipoa.SEMESTRE = "A" and tipoa.ANIO = "'.$date.'") as semestreaa, 
//(SELECT COUNT(tipo.SEMESTRE) FROM tipomovilidad AS tipo WHERE tipo.SEMESTRE = "B" and tipo.ANIO = "'.$date.'") as semestrebb 
//FROM tipomovilidad as tipm INNER JOIN caracteristica as caracte on tipm.idCaracteristica = caracte.ID
//INNER JOIN factores as fact ON fact.id = caracte.id_factor
//LIMIT 1';
        //var_dump($sqlSemestre); exit();
        $resultA = $this->adapter->query($sqlSmestre, Adapter::QUERY_MODE_EXECUTE);

        return $resultA;
    }

    public function saveObservaciones($observaciones, $id) {
        $date = date("Y/m/d");
        foreach ($observaciones as $observacion) {
            $sql = "INSERT INTO observaciones (idUser, observacion, dateCreation) VALUES (" . $id . ", '" . $observacion . "', '" . $date . "')";
            $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        }
    }
    
    public function updateObservaciones($observaciones, $id) {
        $date = date("Y/m/d");
        $i=0;
        foreach ($observaciones as $observacion) {

            $sql = "UPDATE observaciones SET observacion = '".$observacion."', dateModicication = '".$date."' WHERE id = ".$id[$i]." ";
            $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
            $i++;
        }

    }
    
    public function getObservacionesUsers($id){
        $sql = "SELECT id, observacion FROM observaciones WHERE idUser = '".$id."'";
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }

}
