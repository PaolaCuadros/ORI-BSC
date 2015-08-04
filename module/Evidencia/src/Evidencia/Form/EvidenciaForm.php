<?php

namespace Evidencia\Form;

use Zend\Form\Form;

class EvidenciaForm extends Form {
    public function __construct($name = null) {
        parent::__construct('evidencia');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'
        ));
        
        $this->add(array(
            'name' => 'idUsuario',
            'type' => 'Hidden'
        ));
        
        $this->add(array(
           'name' => 'linkFace',
            'type' => 'Text',
            'options' => array(
                'label' => 'linkface',
            ),
        ));
        
        $this->add(array(
           'name' => 'linkYoutube',
            'type' => 'Text',
            'options' => array(
                'label' => 'linkyoutube',
            ),
        ));
        
        $this->add(array(
           'name' => 'linkPagina',
            'type' => 'Text',
            'options' => array(
                'label' => 'linkpagina',
            ),
        ));
        
        $this->add(array(
           'name' => 'linkArchivo',
            'type' => 'Text',
            'options' => array(
                'label' => 'linkarchivo',
            ),
        ));
        
        $this->add(array(
           'name' => 'idCaracteristica',
            'type' => 'Text',
            'options' => array(
                'label' => 'idcaracteristica',
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

