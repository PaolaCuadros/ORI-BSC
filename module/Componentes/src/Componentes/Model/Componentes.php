<?php

namespace Album\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Componentes implements InputFilterAwareInterface {
    public $id;
    public $idFactor;
    public $idCaracteristic;
    public $dateComponent;
    public $dateCreation;
    public $dateEdition;
    public $user;
    
    public function exchangeArray(){
        
    }
    
    public function setInputFilter(){
        
    }
    
    public function getArrayCopy(){
        
    }
    
    public function getInputFilter(){
        
    }
}
