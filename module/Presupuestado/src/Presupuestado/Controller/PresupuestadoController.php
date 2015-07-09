<?php

namespace Presupuestado\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Presupuestado\Form\PresupuestadoForm;
use Presupuestado\Model\Presupuestado;

class PresupuestadoController extends AbstractActionController {

    protected $presupuestadoTable;
    protected $preComponentesTable;
    protected $preFactoresTable;
    protected $preCaracteristicasTable;

    public function indexAction() {
        $id = (int) $this->params()->fromRoute('id', 0);

        $presupuestado = $this->getPresupuestadoTable()->fetchAll($id);
        $caracteristica = $this->getPreCaracteristicasTable()->getCaracteristicaId($id);
        foreach ($caracteristica as $getnameCaracteristica) {
            $nameCaracteristica = $getnameCaracteristica->CARACTERISTICA;
            $idFactor = $getnameCaracteristica->id_factor;
        }
        return array(
            'presupuestado' => $presupuestado,
            'nameCaracteristica' => $nameCaracteristica,
            'idFactor' => $idFactor
        );
    }

    public function addAction() {
        $form = new PresupuestadoForm();
        $idCaracteristica = $this->caracteristicaPresupuestado();
        $request = $this->getRequest();
        $presupuestado = new Presupuestado();
        $form->setInputFilter($presupuestado->getInputFilter());
        $form->setData($request->getPost());
        $data = array(
            'date' => $_POST['date'],
            'semestreA' => $_POST['semestreA'],
            'semestreB' => $_POST['semestreB'],
            'idCaracteristica' => $idCaracteristica,
        );

        $presupuestado->exchangeArray($data);
        $this->getPresupuestadoTable()->savePresupuestado($presupuestado);
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (isset($_POST['anio'])) {//
            $presupuestado = $this->getPresupuestadoTable()->getPresupuestado($_POST['id']);
            $form = new PresupuestadoForm();
            $form->bind($presupuestado);
            $request = $this->getRequest();
            
            if ($request->isPost()) {
                $presupuestado1 = new Presupuestado();
                $form->setInputFilter($presupuestado->getInputFilter());
                $form->setData($request->getPost());
                $data = array(
                    'date' => $_POST['anio'] . "-01-01 00:00:00" ,
                    'semestreA' => $_POST['semestrea'],
                    'semestreB' => $_POST['semestreb'],
                    'id' => $_POST['id'],
                    'idCaracteristica' => $_POST['idCaracterist']
                );
                
                $presupuestado1->exchangeArray($data);
                $this->getPresupuestadoTable()->savePresupuestado($presupuestado1);
            }
            
            return $this->redirect()->toRoute('presupuestado', array(
                    'action' => 'index',
                    'id' => $_POST['idCaracterist']
                ));
            
        } else {
            $getPresupuestado = $this->getPresupuestadoTable()->getPresupuestadoId($id);
            foreach ($getPresupuestado as $presupuestado) {
                $idPresupuesta = $presupuestado->id;
                $datePresupues = $presupuestado->date;
                $semAPresupues = $presupuestado->semestreA;
                $semBPresupues = $presupuestado->semestreB;
                $idCaracterist = $presupuestado->idCaracteristica;
            }

            return array(
                'idPresupuesta' => $idPresupuesta,
                'datePresupues' => substr($datePresupues, 0, 4),
                'semAPresupues' => $semAPresupues,
                'semBPresupues' => $semBPresupues,
                'idCaracterist' => $idCaracterist
            );
        }
    }

    public function getPresupuestadoTable() {
        if (!$this->presupuestadoTable) {
            $sm = $this->getServiceLocator();
            $this->presupuestadoTable = $sm->get('Presupuestado\Model\PresupuestadoTable');
        }
        return $this->presupuestadoTable;
    }

    public function getPreComponentesTable() {
        if (!$this->preComponentesTable) {
            $sm = $this->getServiceLocator();
            $this->preComponentesTable = $sm->get('Componentes\Model\ComponentesTable');
        }
        return $this->preComponentesTable;
    }

    public function getPreFactoresTable() {
        if (!$this->preFactoresTable) {
            $sm = $this->getServiceLocator();
            $this->preFactoresTable = $sm->get('Factores\Model\FactoresTable');
        }
        return $this->preFactoresTable;
    }

    public function getPreCaracteristicasTable() {
        if (!$this->preCaracteristicasTable) {
            $sm = $this->getServiceLocator();
            $this->preCaracteristicasTable = $sm->get('Caracteristica\Model\CaracteristicaTable');
        }
        return $this->preCaracteristicasTable;
    }

    public function caracteristicaPresupuestado() {
        return $this->getPresupuestadoTable()->addPresupuesto();
//        $idCaracteristica;
//        $caracteristica = new Caracteristica();
//        $form->setInputFilter($caracteristica1->getInputFilter());
//        $form->setData($request->getPost());
    }

    public function presupuestadoAction() {
        $componentes = $this->getPreComponentesTable()->fetchAll();
        $factores = $this->getPreFactoresTable();
        $caracteristicas = $this->getPreCaracteristicasTable();
        $presupuestado = $this->getPresupuestadoTable();
        return array(
            'componentes' => $componentes,
            'factores' => $factores,
            'caracteristicas' => $caracteristicas,
            'presupuestado' => $presupuestado
        );
    }

}
