<?php

namespace Observaciones\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;

class Observaciones implements InputFilterAwareInterface {
    protected $inputFilter;
    public $id;
    public $idUser;
    public $observacion;
    public $dateCreation;
    public $dateModicication;
    public $user;
    public $estado;
    public function exchangeArray($data) {
        $this->id    = (isset($data['id'])) ? $data['id'] : null;
        $this->idUser    = (isset($data['idUser'])) ? $data['idUser'] : null;
        $this->observacion    = (isset($data['observacion'])) ? $data['observacion'] : null;
        $this->dateCreation    = (isset($data['dateCreation'])) ? $data['dateCreation'] : null;
        $this->dateModicication    = (isset($data['dateModicication'])) ? $data['dateModicication'] : null;
        $this->user    = (isset($data['user'])) ? $data['user'] : null;
        $this->estado    = (isset($data['estado'])) ? $data['estado'] : null;
        
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
