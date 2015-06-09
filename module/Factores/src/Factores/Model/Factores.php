<?php
// module/Factores/src/Factores/Model/Factores.php:
namespace Factores\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;


class Factores implements InputFilterAwareInterface {

    public $id;
    public $name;
//    public $dateCreation;
//    public $dateEdition;
//    public $user;
    protected $inputFilter;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->idParent = (isset($data['idParent'])) ? $data['idParent'] : null;
//        $this->descripcion = (isset($data['descripcion'])) ? $data['descripcion'] : null;
//        $this->dateCreation = (isset($data['dateCreation'])) ? $data['dateCreation'] : null;
//        $this->dateEdition = (isset($data['dateEdition'])) ? $data['dateEdition'] : null;
//        $this->user = (isset($data['user'])) ? $data['user'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            
        $inputFilter = new InputFilter();
        $factory = new InputFactory();

        $inputFilter->add($factory->createInput(array(
                    'name' => 'id',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Int'),
                    ),
        )));
        
        
        
        $inputFilter->add($factory->createInput(array(
                    'name' => 'idParent',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Int'),
                    ),
        )));
//
        $inputFilter->add($factory->createInput(array(
                    'name' => 'name',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name' => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => 1,
                                'max' => 500,
                            ),
                        ),
                    ),
        )));
        
        
//        $inputFilter->add($factory->createInput(array(
//                    'name' => 'descripcion',
//                    'required' => true,
//                    'filters' => array(
//                        array('name' => 'StripTags'),
//                        array('name' => 'StringTrim'),
//                    ),
//                    'validators' => array(
//                        array(
//                            'name' => 'StringLength',
//                            'options' => array(
//                                'encoding' => 'UTF-8',
//                                'min' => 1,
//                                'max' => 500,
//                            ),
//                        ),
//                    ),
//        )));
        
//        $inputFilter->add($factory->createInput(array(
//                    'name' => 'dateCreation',
//                    'required' => true,
//                    'filters' => array(
//                        array('name' => 'StripTags'),
//                        array('name' => 'StringTrim'),
//                    ),
//                    
//        )));
//        
//        $inputFilter->add($factory->createInput(array(
//                    'name' => 'dateEdition',
//                    'required' => true,
//                    'filters' => array(
//                        array('name' => 'StripTags'),
//                        array('name' => 'StringTrim'),
//                    ),
//                    
//        )));
//        
//        $inputFilter->add($factory->createInput(array(
//                    'name' => 'user',
//                    'required' => true,
//                    'filters' => array(
//                        array('name' => 'Int'),
//                    ),
//        )));
        $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }

}
