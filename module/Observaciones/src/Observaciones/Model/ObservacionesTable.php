<?php

namespace Observaciones\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Mail\Message;
use Zend\Mail\Transport\File as FileTransport;
use Zend\Mail\Transport\FileOptions;
use Zend\Mail\Transport\InMemory as InMemoryTransport;
use Zend\Mail\Transport\Sendmail as SendmailTransport;

class ObservacionesTable extends AbstractTableGateway {

    protected $table = "observaciones";

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Observaciones());
        $this->initialize();
    }

    public function updateObservaciones($observaciones, $id) {
        $date = date("Y/m/d");
        foreach ($observaciones as $observacion) {
            $sql = "INSERT INTO observaciones (idUser, observacion, dateCreation, user, estado) VALUES (" . $id . ", '" . $observacion . "', '" . $date . "', '" . $_SESSION['user'] . "', 1)";
            $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        }
    }

    public function getObservacionesUsers($id) {
        $sql = "SELECT id, observacion, dateCreation, NOMBRE, APELLIDO, idUser
                FROM observaciones as observa 
                INNER JOIN admin as admon ON observa.user =  admon.ID_USUARIO WHERE idUser = '" . $id . "' AND observa.estado = 1 ORDER BY dateCreation desc ";
        //var_dump($sql); exit();
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }

    public function deleteObservacion($id) {
        $sql = 'UPDATE observaciones SET estado = 0 WHERE id = "'.$id.'" ';
                $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
    }

    public function getIdObservacion($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("pailas");
        }
        return $row;
    }
    
    public function getUserObservacion($id){
        $sql = 'SELECT idUser FROM observaciones WHERE id = "'.$id.'" ';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }
    
    public function getAllObservacionesUser($id){
        $sql = "SELECT id, observacion, dateCreation, NOMBRE, APELLIDO, idUser, observa.estado as estado
                FROM observaciones as observa 
                INNER JOIN admin as admon ON observa.user =  admon.ID_USUARIO WHERE idUser = '" . $id . "'  ORDER BY id asc ";
        //var_dump($sql); exit();
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }

}
