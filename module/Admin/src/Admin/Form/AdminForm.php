<?php

namespace Admin\Form;

use Zend\Form\Form;

class AdminForm extends Form {
    public function __construct($name = null) {
        parent::__construct('usuarios');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'ID_USUARIO',
            'type' => 'Hidden'
        ));
        
        $this->add(array(
           'name' => 'NOMBRE',
            'type' => 'Text',
            'options' => array(
                'label' => 'documento',
            ),
        ));
        
        $this->add(array(
           'name' => 'APELLIDO',
            'type' => 'Text',
            'options' => array(
                'label' => 'documento',
            ),
        ));
        
        $this->add(array(
           'name' => 'DIRECCION',
            'type' => 'Text',
            'options' => array(
                'label' => 'documento',
            ),
        ));
        
        $this->add(array(
           'name' => 'TELEFONO',
            'type' => 'Text',
            'options' => array(
                'label' => 'documento',
            ),
        ));
        
        $this->add(array(
           'name' => 'CELULAR',
            'type' => 'Text',
            'options' => array(
                'label' => 'documento',
            ),
        ));
        
        $this->add(array(
           'name' => 'ESTADO',
            'type' => 'Text',
            'options' => array(
                'label' => 'documento',
            ),
        ));
    }
}

