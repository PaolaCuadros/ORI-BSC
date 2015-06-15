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
        parent::indexAction();
    }

    public function addAction() {
        //var_dump($_POST); exit();
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

        //var_dump($_POST['fecha']); exit();
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
//        foreach($componentes as $componente) {
//            die(print_r($componente->id));
//            //$factores = $this->getPreFactoresTable()->getAllFactorComponente($componente->id);
//        }
//        $componentes = $this->getPresupuestadoTable()->getPdiPresupuestado();
        //var_dump($componentes); exit();
        
//        foreach ($componentes['componente'] as $componente){
//            $nameComponente[] = $componente;
//        }
//        
//        foreach ($componentes['factores'] as $factores){
//            $nameFactores[] = $factores;
//        }
//        
//        foreach ($componentes['caracteristica'] as $caracteristica){
//            $nameCaracteristica[] = $caracteristica;
//        }
//        
//        foreach ($componentes['contador'] as $contador){
//            $numContador[] = $contador;
//        }
        
        
        
        //var_dump($nameCaracteristica); exit();
        return array (
            'componentes' => $componentes,
            'factores' => $factores,
            'caracteristicas' => $caracteristicas,
            'presupuestado' => $presupuestado
        );
        // = $this->getPresupuestadoTable()->getPdiPresupuestado();
        
//        //var_dump($componentes['compara']['idCaracteristica']); exit();
//        
//        $consolidado = array(
//            'componentes' => $componentes['sendData']['componente'],
//            'factores' => $componentes['sendData']['factor'],
//            'caracteristicas' => $componentes['sendData']['caracteristica'],
//            'idFactor' => $componentes['compara']['idFactor'],
//            'caracId' => $componentes['compara']['idCaracteristica'],
//        );
//
//
//
//         //var_dump($componentes['sendData']['caracteristica']); echo "<br/>"; exit();
//
//        return array(
//            'componentes' => $componentes['sendData']['componente'],
//            'factores' => $componentes['sendData']['factor'],
//            'caracteristicas' => $componentes['sendData']['caracteristica'],
//            'compara' => array('idFactor' => $componentes['compara']['idFactor'],
//                                'caracId' => $componentes['compara']['idCaracteristica'],),
//            
//        );
    }

}
