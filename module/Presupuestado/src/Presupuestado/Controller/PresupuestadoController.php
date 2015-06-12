<?php

namespace Presupuestado\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Presupuestado\Form\PresupuestadoForm;
use Presupuestado\Model\Presupuestado;

class PresupuestadoController extends AbstractActionController {

    protected $presupuestadoTable;

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

    public function caracteristicaPresupuestado() {
        return $this->getPresupuestadoTable()->addPresupuesto();
//        $idCaracteristica;
//        $caracteristica = new Caracteristica();
//        $form->setInputFilter($caracteristica1->getInputFilter());
//        $form->setData($request->getPost());
    }

}
