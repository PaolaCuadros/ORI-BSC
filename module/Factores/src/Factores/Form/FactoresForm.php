<?php
namespace Factores\Form;

use Zend\Form\Form;

class FactoresForm extends Form{
    public function __construct($name = null)
    {
        
        // we want to ignore the name passed
        parent::__construct('factores');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(
                'label' => 'name',
            ),
        ));
//        $this->add(array(
//            'name' => 'dateCreation',
//            'type' => 'datetime',
//            'options' => array(
//                'label' => 'dateCreation',
//            ),
//        ));
//        $this->add(array(
//            'name' => 'dateEdition',
//            'type' => 'datetime',
//            'options' => array(
//                'label' => 'dateEdition',
//            ),
//        ));
//        $this->add(array(
//            'name' => 'user',
//            'type' => 'int',
//            'options' => array(
//                'label' => 'user',
//            ),
//        ));
        
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
