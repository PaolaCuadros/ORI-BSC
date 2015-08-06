<?php

namespace Evidencia\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonMode;
use Evidencia\Model\Evidencia;
use Evidencia\Form\EvidenciaForm;

class EvidenciaController extends AbstractActionController {

    protected $usuariosTable;
    protected $evidenciaTable;
   

    public function indexAction() {


        parent::indexAction();
    }

    public function addAction() {

        if (isset($_POST['anio'])) {
            $id = (int) $this->params()->fromRoute('id', 0);
            $nameUsuario = $this->getUsuariosTable()->getUsuarioCaracteristica($_POST['idCaracteristica'], $_POST['anio']);
            return array(
                'nameUsuario' => $nameUsuario,
                'anio' => $_POST['anio'],
                'id' => $_POST['idCaracteristica']
            );
        } else {
            $id = (int) $this->params()->fromRoute('id', 0);
            $form = new EvidenciaForm();
            $optiExisteUsuario = $this->getUsuariosTable()->existeUsuarioCaracteristica($id);
            
            foreach ($optiExisteUsuario as $existeUsuario){
                $idUserExiste = $existeUsuario->ID;
            }
            
            if(!isset($idUserExiste)){
                //var_dump("aca"); exit();
                
               
                return $this->redirect()->toRoute('usuarios', array(
                            'action' => 'addusuariosestadisticas', 'id' => $id
                ));
            }
            
            $nameUsuario = $this->getUsuariosTable()->getUsuarioCaracteristica($id, 0);

            $request = $this->getRequest();
            if ($request->isPost()) {

                $evidencia = new Evidencia();
                $form->setInputFilter($evidencia->getInputFilter());
                $form->setData($request->getPost());
                $data = array();
                
                //var_dump($_FILES['archivo']); exit();
                if (isset($_FILES['archivo'])) {

                    if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                        $dir = __DIR__ . "/../img";
                        $tmp = $_FILES['archivo']['tmp_name'];

                        $file = $_FILES['archivo']['name'];
                        $new_path = $dir . "/" . $file;
                        //var_dump($new_path); exit();
                        if (move_uploaded_file($tmp, $new_path)) {
                            echo "El Arhivo " . $file . " fue subido con exito";
                        }
                    } else {
                        $new_path = "";
                        print ("No se ha podido subir el fichero");
                    }
                }



                $evidencia->exchangeArray($data);
                $this->getEvidenciaTable()->saveEvidencia($evidencia, $new_path);

                return $this->redirect()->toRoute('ejecutado', array(
                            'action' => 'index'
                ));
            }

            return array(
                'nameUsuario' => $nameUsuario,
                'id' => $id
            );
        }
    }

    public function editAction() {
        
    }

    public function deleteAction() {
        
    }

    public function getUsuariosTable() {
        if (!$this->usuariosTable) {
            $sm = $this->getServiceLocator();
            $this->usuariosTable = $sm->get('Usuarios\Model\UsuariosTable');
        }
        return $this->usuariosTable;
    }

    public function getEvidenciaTable() {
        if (!$this->evidenciaTable) {
            $sm = $this->getServiceLocator();
            $this->evidenciaTable = $sm->get('Evidencia\Model\EvidenciaTable');
        }
        return $this->evidenciaTable;
    }
    
    

}
