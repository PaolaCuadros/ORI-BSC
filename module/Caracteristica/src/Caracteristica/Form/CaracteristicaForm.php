<?php

namespace Caracteristica\Form;

use Zend\Form\Form;

class CaracteristicaForm extends Form {
    public function __construct($name = null) {
        parent::__construct('caracteristica');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'
        ));
        
        $this->add(array(
            'name' => 'id_factor',
            'type' => 'Hidden'
        ));
        
        $this->add(array(
           'name' => 'caracteristica',
            'type' => 'Text',
            'options' => array(
                'label' => 'name',
            ),
        ));
    }
}


