<?php

namespace Evidencia\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class EvidenciaTable extends AbstractTableGateway {
    protected $table = 'evidencia';
    
    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Evidencia());
        $this->initialize();
    }
    
    public function saveEvidencia(Evidencia  $evidencia, $url){
        //var_dump($url); exit();
//        $urlArchivo = '';
//        if($_POST['urlArchivo'] != ''){
//            $urlArchivo = $_POST['urlArchivo'];
//        }else if($_POST['url'] != '') {
//            $urlArchivo =  $_POST['url'];
//        }
        
        
        
        //var_dump($url); exit();
        $data = array(
            'idUsuario' => $_POST['estudiante'],
            'linkFace' => $_POST['linkface'],
            'linkYoutube' => $_POST['linkyoutube'],
            'linkPagina' => $_POST['linkpagina'],
            'linkArchivo' => $url,
            'idCaracteristica' => $_POST['idCaracteristica'],
            'dateCreation' => date("Y-d-m"),
            'user' => $_SESSION['user']
        );
        
        $this->insert($data);
        
        
    }
    
    public function getEvidenciasIndicadores($id){
//        $sql = 'SELECT linkArchivo, linkFace, linkPagina, linkYoutube FROM usuario as usu 
//            INNER JOIN tipomovilidad AS tipo ON tipo.ID_USUARIO = usu.DOCUMENTO_IDENTIDAD
//            INNER JOIN evidencia AS eviden ON eviden.idUsuario = usu.ID 
//            INNER JOIN caracteristica AS carac ON carac.ID = tipo.idCaracteristica
//            WHERE carac.ID = 1';
        $sql = 'SELECT linkArchivo, linkFace, linkPagina, linkYoutube FROM evidencia AS eviden 
                INNER JOIN caracteristica AS carac ON carac.ID = eviden.idCaracteristica
                WHERE carac.ID = "'.$id.'"';
        $result = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $result;
    }
    
    public function getEvidenciasUsuario($id, $idUsuario = NULL){
        if(!isset($idUsuario) || ($idUsuario == NULL)){
            $where = 'WHERE carac.ID = "'.$id.'"';
        }else{
            $where = 'WHERE carac.ID = "'.$id.'" AND eviden.idUsuario = "'.$idUsuario.'"';
        }
        
        $sql = 'SELECT eviden.idUsuario as idUsuario, linkArchivo, linkFace, linkPagina, linkYoutube FROM usuario as usu 
                INNER JOIN tipomovilidad AS tipo ON tipo.ID_USUARIO = usu.DOCUMENTO_IDENTIDAD
                INNER JOIN evidencia AS eviden ON eviden.idUsuario = usu.ID 
                INNER JOIN caracteristica AS carac ON carac.ID = tipo.idCaracteristica
                ' . $where;
        
        //VAR_DUMP($sql);
        $result = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $result;
    }
    
//    public function getEvidenciasUsuario1($id, $idUsuario){
//        if(!isset($idUsuario) || ($idUsuario == NULL)){
//            $where = 'WHERE carac.ID = "'.$id.'"';
//        }else{
//            $where = 'WHERE carac.ID = "'.$id.'" AND eviden.idUsuario = "'.$idUsuario.'"';
//        }
//        
//        $sql = 'SELECT eviden.idUsuario as idUsuario, linkArchivo, linkFace, linkPagina, linkYoutube FROM usuario as usu 
//                INNER JOIN tipomovilidad AS tipo ON tipo.ID_USUARIO = usu.DOCUMENTO_IDENTIDAD
//                INNER JOIN evidencia AS eviden ON eviden.idUsuario = usu.ID 
//                INNER JOIN caracteristica AS carac ON carac.ID = tipo.idCaracteristica
//                ' . $where;
//        
//        VAR_DUMP($sql);
//        $result = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
//        return $result;
//    }
}
