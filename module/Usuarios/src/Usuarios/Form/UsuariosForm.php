<?php

namespace Usuarios\Form;

use Zend\Form\Form;

class UsuariosForm extends Form {
    public function __construct($name = null) {
        parent::__construct('usuarios');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'
        ));
        
        $this->add(array(
           'name' => 'DOCUMENTO_IDENTIDAD',
            'type' => 'Text',
            'options' => array(
                'label' => 'documento',
            ),
        ));
        
        $this->add(array(
           'name' => 'CODIGO_ESTUDIANTIL',
            'type' => 'Text',
            'options' => array(
                'label' => 'cod_estud',
            ),
        ));
        
        $this->add(array(
           'name' => 'NOMBRE',
            'type' => 'Text',
            'options' => array(
                'label' => 'name',
            ),
        ));
        
        $this->add(array(
           'name' => 'APELLIDO',
            'type' => 'Text',
            'options' => array(
                'label' => 'last_name',
            ),
        ));
        
        $this->add(array(
           'name' => 'DIRECCION',
            'type' => 'Text',
            'options' => array(
                'label' => 'direccion',
            ),
        ));
        
        $this->add(array(
           'name' => 'CODIGO_POSTAL',
            'type' => 'Text',
            'options' => array(
                'label' => 'cod_postal',
            ),
        ));
        
        $this->add(array(
           'name' => 'TELEFONO',
            'type' => 'Text',
            'options' => array(
                'label' => 'telefono',
            ),
        ));
        
        $this->add(array(
           'name' => 'CELULAR',
            'type' => 'Text',
            'options' => array(
                'label' => 'celular',
            ),
        ));
        
        $this->add(array(
           'name' => 'SEXO',
            'type' => 'Text',
            'options' => array(
                'label' => 'sexo',
            ),
        ));
        
        $this->add(array(
           'name' => 'ID_CARRERA',
            'type' => 'Text',
            'options' => array(
                'label' => 'carrera',
            ),
        ));
        
        $this->add(array(
           'name' => 'COMPROMISOS',
            'type' => 'Text',
            'options' => array(
                'label' => 'compromisos',
            ),
        ));
        
        $this->add(array(
           'name' => 'OBSERVACIONES',
            'type' => 'Text',
            'options' => array(
                'label' => 'observaciones',
            ),
        ));
        
        $this->add(array(
           'name' => 'PROINTERES',
            'type' => 'Text',
            'options' => array(
                'label' => 'prog_interes',
            ),
        ));
        
        $this->add(array(
           'name' => 'SEMESTRE',
            'type' => 'Text',
            'options' => array(
                'label' => 'semestre',
            ),
        ));
        
        $this->add(array(
           'name' => 'EMAIL',
            'type' => 'Text',
            'options' => array(
                'label' => 'email',
            ),
        ));
    }
}

