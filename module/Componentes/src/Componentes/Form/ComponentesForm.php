<?php

namespace Componentes\Form;

use Zend\Form\Form;

class ComponentesForm extends Form {
    public function __construct($name = null) {
        parent::__construct('componentes');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Hidden'
        ));
        
//        $this->add(array(
//           'name' => 'caracteristica',
//            'type' => 'Text',
//            'options' => array(
//                'label' => 'name',
//            ),
//        ));
    }
}


