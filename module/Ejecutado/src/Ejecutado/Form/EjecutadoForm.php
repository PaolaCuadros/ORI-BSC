<?php

namespace Ejecutado\Form;

use Zend\Form\Form;

class EjecutadoForm extends Form{
    public function __construct($name = null) {
        parent::__construct('ejecutado');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'anio',
            'type' => 'Text',
            'options' => array(
                'label' => 'name',
            ),
        ));
        
        $this->add(array(
            'name' => 'semestre',
            'type' => 'Text',
            'options' => array(
                'label' => 'name',
            ),
        ));
        
        $this->add(array(
            'name' => 'idCaracteristica',
            'type' => 'Text',
            'options' => array(
                'label' => 'name',
            ),
        ));
        
        $this->add(array(
            'name' => 'calificacion',
            'type' => 'Text',
            'options' => array(
                'label' => 'name',
            ),
        ));
        
        $this->add(array(
            'name' => 'archivo',
            'type' => 'Text',
            'options' => array(
                'label' => 'name',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}

