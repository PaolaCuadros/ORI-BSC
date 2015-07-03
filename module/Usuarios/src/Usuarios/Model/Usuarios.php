<?php

namespace Usuarios\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;

class Usuarios implements InputFilterAwareInterface{
    public $id;
    public $documento;
    public $cod_estud;
    public $nombre;
    public $last_name;
    public $direccion;
    public $cod_postal;
    public $telefono;
    public $celular;
    public $sexo;
    public $carrera;
    public $compromisos;
    public $observaciones;
    public $prog_interes;
    public $semestre;
    public $email;
    public $estado;
    public $otro_prog_interes;


    protected $inputFilter;
    
    public function exchangeArray($data) {
        $this->id = (isset($data['ID'])) ? $data['ID'] : null;
        $this->documento = (isset($data['DOCUMENTO_IDENTIDAD'])) ? $data['DOCUMENTO_IDENTIDAD'] : null;
        $this->cod_estud = (isset($data['CODIGO_ESTUDIANTIL'])) ? $data['CODIGO_ESTUDIANTIL'] : null;
        $this->nombre = (isset($data['NOMBRE'])) ? $data['NOMBRE'] : null;
        $this->last_name = (isset($data['APELLIDO'])) ? $data['APELLIDO'] : null;
        $this->direccion = (isset($data['DIRECCION'])) ? $data['DIRECCION'] : null;
        $this->cod_postal = (isset($data['CODIGO_POSTAL'])) ? $data['CODIGO_POSTAL'] : null;
        $this->telefono = (isset($data['TELEFONO'])) ? $data['TELEFONO'] : null;
        $this->celular = (isset($data['CELULAR'])) ? $data['CELULAR'] : null;
        $this->sexo = (isset($data['SEXO'])) ? $data['SEXO'] : null;
        $this->carrera = (isset($data['ID_CARRERA'])) ? $data['ID_CARRERA'] : null;
        
        $this->semestre = (isset($data['SEMESTRE'])) ? $data['SEMESTRE'] : null;
        $this->prog_interes = (isset($data['PROINTERES'])) ? $data['PROINTERES'] : null;
        $this->compromisos = (isset($data['COMPROMISOS'])) ? $data['COMPROMISOS'] : null;
        $this->observaciones = (isset($data['OBSERVACIONES'])) ? $data['OBSERVACIONES'] : null;
        $this->email = (isset($data['EMAIL'])) ? $data['EMAIL'] : null;
        $this->estado = (isset($data['ESTADO'])) ? $data['ESTADO'] : null;
        $this->otro_prog_interes = (isset($data['OTROPROGINTERES'])) ? $data['OTROPROGINTERES'] : null;

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
                        'name' => 'ID_USUARIO',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'DOCUMENTO_IDENTIDAD',
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
                                    'max' => 20,
                                ),
                            ),
                        ),
            )));
            
            
            $inputFilter->add($factory->createInput(array(
                        'name' => 'CODIGO_ESTUDIANTIL',
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
                                    'max' => 20,
                                ),
                            ),
                        ),
            )));
            
            
            $inputFilter->add($factory->createInput(array(
                        'name' => 'NOMBRE',
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
                                    'max' => 100,
                                ),
                            ),
                        ),
            )));
            
            
            $inputFilter->add($factory->createInput(array(
                        'name' => 'APELLIDO',
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
                                    'max' => 100,
                                ),
                            ),
                        ),
            )));
            
            
            $inputFilter->add($factory->createInput(array(
                        'name' => 'DIRECCION',
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
                                    'max' => 50,
                                ),
                            ),
                        ),
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'CODIGO_POSTAL',
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
                                    'max' => 10,
                                ),
                            ),
                        ),
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'TELEFONO',
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
                                    'max' => 20,
                                ),
                            ),
                        ),
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'CELULAR',
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
                                    'max' => 20,
                                ),
                            ),
                        ),
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'SEXO',
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
                                    'max' => 1,
                                ),
                            ),
                        ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                        'name' => 'ID_CARRERA',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                        'name' => 'COMPROMISOS',
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
                                    'max' => 1,
                                ),
                            ),
                        ),
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'OBSERVACIONES',
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
                                    'max' => 1,
                                ),
                            ),
                        ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                        'name' => 'PROINTERES',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                        'name' => 'SEMESTRE',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                        'name' => 'EMAIL',
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
                                    'max' => 100,
                                ),
                            ),
                        ),
            )));
            
            
            
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}

