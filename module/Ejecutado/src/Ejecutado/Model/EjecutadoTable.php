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

    public function fetchAll() {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function saveEjecutado(Ejecutado $ejecutado, $url) {
        $id = 0;

        if ($url == "") {
            $data = array(
                'ANIO' => $_POST['anio'],
                'SEMESTRE' => $_POST['semestre'],
                'CALIFICACION' => $_POST['calificacion'],
                'IDCARACTERISTICA' => $_POST['idCaracteristica']
            );
        } else {
            $data = array(
                'ANIO' => $_POST['anio'],
                'SEMESTRE' => $_POST['semestre'],
                'CALIFICACION' => $_POST['calificacion'],
                'URL' => $url,
                'IDCARACTERISTICA' => $_POST['idCaracteristica']
            );
        }

        if (isset($_POST['id']))
            $id = (int) $_POST['id'];
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getEjecutado($id)) {
                $this->update($data, array('id' => $id));
            }
        }
    }

    public function getEjecutadoCaracteristica($id) {
        $resultSet = $this->select(array('ID' => $id));
        return $resultSet;
    }

    public function getEjecutado($id) {
        $id = (int) $id;
        //var_dump($id); exit();
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("pailas");
        }
        return $row;
    }
    
    public function getEjecutadoM($id, $date) {
        $sqlSemestreA = 'SELECT 
(SELECT tipoa.CALIFICACION FROM ejecutado AS tipoa WHERE tipoa.SEMESTRE = "A" and tipoa.IDCARACTERISTICA = "' . $id . '" and tipoa.ANIO = "' . $date . '") as semestreaa, 
(SELECT ida.ID FROM ejecutado AS ida WHERE ida.SEMESTRE = "A" and ida.IDCARACTERISTICA = "' . $id . '" and ida.ANIO = "' . $date . '") as semestreaaid, 
(SELECT tipo.CALIFICACION FROM ejecutado AS tipo WHERE tipo.SEMESTRE = "B" and tipo.IDCARACTERISTICA = "' . $id . '" and tipo.ANIO = "' . $date . '") as semestrebb,
(SELECT idb.ID FROM ejecutado AS idb WHERE idb.SEMESTRE = "B" and idb.IDCARACTERISTICA = "' . $id . '" and idb.ANIO = "' . $date . '") as semestrebbid, tipm.IDCARACTERISTICA as idCaracteristica
FROM ejecutado as tipm WHERE tipm.IDCARACTERISTICA = "' . $id . '" LIMIT 1';

        $resultA = $this->adapter->query($sqlSemestreA, Adapter::QUERY_MODE_EXECUTE);
        return $resultA;
    }
    
    public function getCaracteristicaEjecutado($id) {
        $resultSet = 'SELECT IDCARACTERISTICA FROM ejecutado WHERE ID = '.$id.'';
        $result = $this->adapter->query($resultSet, Adapter::QUERY_MODE_EXECUTE);
        return $result;
    }

}
