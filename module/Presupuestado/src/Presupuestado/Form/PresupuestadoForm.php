<?php

namespace Presupuestado\Form;

use Zend\Form\Form;

class PresupuestadoForm extends Form {
    public function __construct($name = null){
         parent::__construct('factores');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'semestreA',
            'type' => 'Text',
            'options' => array(
                'label' => 'name',
            ),
        ));
        
        $this->add(array(
            'name' => 'semestreB',
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

