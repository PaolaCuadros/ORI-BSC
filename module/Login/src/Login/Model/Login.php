<?php
// module/Factores/src/Factores/Model/Factores.php:
namespace Login\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;


class Login implements InputFilterAwareInterface {
    protected $inputFilter;
    
    public function exchangeArray($data) {
        
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }
    
    public function getInputFilter() {
        
    }
}

