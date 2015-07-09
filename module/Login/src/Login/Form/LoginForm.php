<?php
namespace Login\Form;

use Zend\Form\Form;

class LoginForm extends Form{
    public function __construct($name = null)
    {
        
        // we want to ignore the name passed
        parent::__construct('login');
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
        
        $this->add(array(
            'name' => 'contrasena',
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
