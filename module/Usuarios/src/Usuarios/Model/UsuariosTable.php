<?php

namespace Usuarios\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Mail\Message;
use Zend\Mail\Transport\File as FileTransport;
use Zend\Mail\Transport\FileOptions;
use Zend\Mail\Transport\InMemory as InMemoryTransport;
use Zend\Mail\Transport\Sendmail as SendmailTransport;

class UsuariosTable extends AbstractTableGateway {

    protected $table = "usuario";

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Usuarios());
        $this->initialize();
    }

    public function fetchAll() {
        $sql = 'SELECT usu.ID as id, usu.CODIGO_ESTUDIANTIL as cod_estud, usu.NOMBRE as name, usu.APELLIDO as last_name, usu.TELEFONO as telefono, usu.SEMESTRE as semestre, proin.name as prog_interes, usu.COMPROMISOS as compromisos, usu.OBSERVACIONES as observaciones, usu.EMAIL as email, car.NOMBRE as carrera, usu.FECHA_CREACION, usu.ESTADO, usu.CELULAR as celular, usu.OTROEMAIL as otroEmail
FROM usuario as usu INNER JOIN carrera as car on car.ID_CARRERA = usu.ID_CARRERA INNER JOIN programainteres AS proin on proin.id = usu.PROINTERES';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }

    public function saveUsuario(Usuarios $usuarios) {
        $id = 0;
        if(isset($_POST['otro_prog_interes'])){

            $otro_prog_interes = $_POST['otro_prog_interes'];
        }else{
            $otro_prog_interes = "";
        }
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
            'OTROPROGINTERES' => $otro_prog_interes,
            'FECHACOMPROMISO' => $_POST['fechaCompromiso'],
            'FECHA_CREACION' => date("Y/m/d"),
            'CELULAR' => $_POST['celular'],
            'OTROEMAIL' => $_POST['otro_email'],
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
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("pailas");
        }
        return $row;
    }

    public function getEjecutadoCaracteristica($id, $date) {
        $sqlSemestreA = 'SELECT (SELECT COUNT(tipoa.SEMESTRE) FROM tipomovilidad AS tipoa WHERE tipoa.SEMESTRE = "A" and tipoa.idCaracteristica = "' . $id . '" and tipoa.ANIO = "' . $date . '") as semestreaa, (SELECT COUNT(tipo.SEMESTRE) FROM tipomovilidad AS tipo WHERE tipo.SEMESTRE = "B" and tipo.idCaracteristica = "' . $id . '" and tipo.ANIO = "' . $date . '") as semestrebb FROM tipomovilidad as tipm WHERE tipm.idCaracteristica = "' . $id . '" LIMIT 1';

        $resultA = $this->adapter->query($sqlSemestreA, Adapter::QUERY_MODE_EXECUTE);
        return $resultA;
    }

    public function getDateEjecutado() {
        $sql = "SELECT DISTINCT ANIO as fecha FROM tipomovilidad";
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }

public function sumEjecutadoCaracteristica($id, $date, $componente, $indicador) {
        if ($componente == 5) {
            $sqlSmestre = 'SELECT
(SELECT COUNT(ejecu.SEMESTRE) FROM ejecutado AS ejecu 
INNER JOIN caracteristica AS caract ON ejecu.IDCARACTERISTICA = caract.ID 
INNER JOIN factores AS fact ON caract.id_factor = fact.id 
INNER JOIN componentes AS comp ON comp.id = fact.idParent
WHERE comp.id = ' . $componente . ' AND ejecu.SEMESTRE = "A" AND ejecu.CALIFICACION >= "1" AND ejecu.ANIO = "' . $date . '") AS semestreaa,

(SELECT COUNT(ejecu.SEMESTRE) FROM ejecutado AS ejecu 
INNER JOIN caracteristica AS caract ON ejecu.IDCARACTERISTICA = caract.ID 
INNER JOIN factores AS fact ON caract.id_factor = fact.id 
INNER JOIN componentes AS comp ON comp.id = fact.idParent
WHERE comp.id = ' . $componente . ' AND ejecu.SEMESTRE = "B" AND ejecu.CALIFICACION >= "1" AND ejecu.ANIO = "' . $date . '") AS semestrebb

FROM componentes AS com WHERE com.ID = ' . $componente . '';
        } else if (($id >= 1) && ($id <= 4)) {
            $sqlSmestre = 'SELECT (SELECT COUNT(tipoa.SEMESTRE) FROM tipomovilidad AS tipoa INNER JOIN caracteristica as caracte on tipoa.idCaracteristica = caracte.ID INNER JOIN factores as fact ON fact.id = caracte.id_factor AND fact.id=' . $id . ' WHERE tipoa.SEMESTRE = "A" and tipoa.ANIO = "' . $date . '") as semestreaa, (SELECT COUNT(tipo.SEMESTRE) FROM tipomovilidad AS tipo INNER JOIN caracteristica as caracte on tipo.idCaracteristica = caracte.ID INNER JOIN factores as fact ON fact.id = caracte.id_factor AND fact.id=' . $id . ' WHERE tipo.SEMESTRE = "B" and tipo.ANIO = "' . $date . '") as semestrebb, fact.id FROM tipomovilidad as tipm INNER JOIN caracteristica as caracte on tipm.idCaracteristica = caracte.ID INNER JOIN factores as fact ON fact.id = caracte.id_factor AND fact.id=' . $id . ' limit 1';
        }else{
            $sqlSmestre = 'SELECT 
            (SELECT COUNT(ejecuta.SEMESTRE) 
             FROM indicadores AS indica 
             INNER JOIN factores as fact ON fact.idIndicador = indica.ID AND indica.ID = ' . $indicador . '
             INNER JOIN caracteristica as caracte ON caracte.id_factor = fact.id
             INNER JOIN ejecutado AS ejecuta ON ejecuta.IDCARACTERISTICA = caracte.ID 
             WHERE ejecuta.SEMESTRE = "A" AND ejecuta.ANIO = "' . $date . '") as semestreaa, 

            (SELECT COUNT(ejecuta.SEMESTRE) 
             FROM indicadores AS indica 
             INNER JOIN factores as fact ON fact.idIndicador = indica.ID AND indica.ID = ' . $indicador . '
             INNER JOIN caracteristica as caracte ON caracte.id_factor = fact.id
             INNER JOIN ejecutado AS ejecuta ON ejecuta.IDCARACTERISTICA = caracte.ID 
             WHERE ejecuta.SEMESTRE = "A" AND ejecuta.ANIO = "' . $date . '") as semestrebb

            FROM indicadores as indicadores WHERE indicadores.ID = ' . $indicador . '';
        }
        $resultA = $this->adapter->query($sqlSmestre, Adapter::QUERY_MODE_EXECUTE);

        return $resultA;
    }

    
    
    
    
    
    public function sumEjecutadoFactor($id, $date, $idCaracte = null){
        
        if(($id >= 1) && ($id <= 4)){
            $sumEjecutado = '
                SELECT 
(SELECT COUNT(tipmov.ID_USUARIO) FROM tipomovilidad AS tipmov INNER JOIN caracteristica AS caracter ON tipmov.idCaracteristica = caracter.ID INNER JOIN factores AS fact ON fact.id = caracter.id_factor WHERE tipmov.SEMESTRE = "A" AND fact.id = '.$id.' AND tipmov.ANIO = "'.$date.'" AND caracter.ID = '.$idCaracte.') AS semestreaa, 
(SELECT COUNT(tipmov.ID_USUARIO) FROM tipomovilidad AS tipmov INNER JOIN caracteristica AS caracter ON tipmov.idCaracteristica = caracter.ID INNER JOIN factores AS fact ON fact.id = caracter.id_factor WHERE tipmov.SEMESTRE = "B" AND fact.id = '.$id.' AND tipmov.ANIO = "'.$date.'" AND caracter.ID = '.$idCaracte.') AS semestrebb 
FROM factores WHERE id = '.$id.'
';
        }else{
            $sumEjecutado = 'SELECT 
(SELECT SUM(tipoa.CALIFICACION) FROM ejecutado AS tipoa INNER JOIN caracteristica as caracte on tipoa.IDCARACTERISTICA = caracte.ID INNER JOIN factores as fact ON fact.id = caracte.id_factor AND fact.id='.$id.' WHERE tipoa.SEMESTRE = "A" and tipoa.ANIO = "'.$date.'") as semestreaa, 
(SELECT SUM(tipob.CALIFICACION) FROM ejecutado AS tipob INNER JOIN caracteristica as caracte on tipob.IDCARACTERISTICA = caracte.ID INNER JOIN factores as fact ON fact.id = caracte.id_factor AND fact.id='.$id.' WHERE tipob.SEMESTRE = "B" and tipob.ANIO = "'.$date.'")as semestrebb  FROM ejecutado as tipm 
INNER JOIN caracteristica as caracte on tipm.IDCARACTERISTICA = caracte.ID 
INNER JOIN factores as fact ON fact.id = caracte.id_factor AND fact.id='.$id.' limit 1';
        }
         
        $resultA = $this->adapter->query($sumEjecutado, Adapter::QUERY_MODE_EXECUTE);

        return $resultA;
    }
    

    public function sendEmail($html) {


        $para = 'lizeth.cuadros@unibague.edu.co' . ', '; 
        $para .= 'lizeth.cuadros@unibague.edu.co';
        $título = 'Compromisos ORI';

        $cabeceras = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= 'To: ORI <lizeth.cuadros@unibague.edu.co>' . "\r\n";
        $cabeceras .= 'From: Compromisos ORI <lizeth.cuadros@unibague.edu.co>' . "\r\n";
        $sendEmail = mail($para, $título, $html, $cabeceras);
        return $sendEmail;
    }

    public function getDateCommitmentUser($dateActual, $day) {
        $sql = 'SELECT NOMBRE, APELLIDO, CODIGO_ESTUDIANTIL, FECHACOMPROMISO, COMPROMISOS FROM usuario WHERE FECHACOMPROMISO BETWEEN "' . $dateActual . '" AND "' . $day . '"';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }
    
    public function getUsuarioBsc($id, $anio, $carac){
        $sql = 'SELECT  usu.ID as idUsuario, usu.NOMBRE as nombre, USU.APELLIDO as apellido, car.NOMBRE  as carrera, usu.CODIGO_ESTUDIANTIL as codEstu FROM caracteristica AS caract 
INNER JOIN tipomovilidad AS tipmo ON caract.ID = tipmo.idCaracteristica 
INNER JOIN usuario AS usu ON usu.DOCUMENTO_IDENTIDAD = tipmo.ID_USUARIO
INNER JOIN carrera AS car ON car.ID_CARRERA = USU.ID_CARRERA
WHERE caract.id_factor = '.$id.' AND tipmo.ANIO = "'.$anio.'" AND caract.ID = '.$carac.'';
        //var_dump($sql); exit();
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }
    
    public function getUsuarioObservaciones($id){
        $sql = 'SELECT NOMBRE, APELLIDO FROM usuario WHERE ID = "'.$id.'"';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }
    
    public function getUsuarioCaracteristica($id, $anio){
        //var_dump($anio); exit();
        if($anio == 0){
            $sql = 'SELECT usu.ID, usu.NOMBRE, usu.APELLIDO FROM usuario AS usu 
                INNER JOIN tipomovilidad AS tipo ON tipo.ID_USUARIO = usu.DOCUMENTO_IDENTIDAD
                WHERE idCaracteristica = "'.$id.'"';
        }else{
            $sql = 'SELECT usu.ID, usu.NOMBRE, usu.APELLIDO FROM usuario AS usu 
                INNER JOIN tipomovilidad AS tipo ON tipo.ID_USUARIO = usu.DOCUMENTO_IDENTIDAD
                WHERE idCaracteristica = "'.$id.'" AND tipo.ANIO = "'.$anio.'"';
        }
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }
    
    public function existeUsuarioCaracteristica($id){
        $sql = 'SELECT usu.ID FROM usuario AS usu 
                INNER JOIN tipomovilidad AS tipo ON tipo.ID_USUARIO = usu.DOCUMENTO_IDENTIDAD
                WHERE idCaracteristica = "'.$id.'"';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
        
    }
    
    public function getUniversidad(){
        $sql = 'SELECT ID_UNIVERSIDAD, NOMBRE FROM universidad';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }
    
    public function getCarrera(){
        $sql = 'SELECT ID_CARRERA, NOMBRE FROM carrera';
        $results = $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }
    
    
    
}
