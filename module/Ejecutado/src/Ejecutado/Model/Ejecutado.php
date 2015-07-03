<?php

namespace Ejecutado\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;

class Ejecutado implements InputFilterAwareInterface {

    protected $inputFilter;
    public $id;
    public $idCaracteristica;
    public $anio;
    public $semestre;
    public $calificacion;
    public $url;

    public function exchangeArray($data) {
        $this->id = (isset($data['ID'])) ? $data['ID'] : null;
        $this->idCaracteristica = (isset($data['IDCARACTERISTICA'])) ? $data['IDCARACTERISTICA'] : null;
        $this->anio = (isset($data['ANIO'])) ? $data['ANIO'] : null;
        $this->semestre = (isset($data['SEMESTRE'])) ? $data['SEMESTRE'] : null;
        $this->calificacion = (isset($data['CALIFICACION'])) ? $data['CALIFICACION'] : null;
        $this->url = (isset($data['URL'])) ? $data['URL'] : null;
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
                        'name' => 'ANIO',
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
                                    'max' => 4,
                                ),
                            ),
                        ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                        'name' => 'SEMESTRE',
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
                                    'max' => 15,
                                ),
                            ),
                        ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                        'name' => 'IDCARACTERISTICA',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                        'name' => 'CALIFICACION',
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
                                    'max' => 15,
                                ),
                            ),
                        ),
            )));
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }

}
