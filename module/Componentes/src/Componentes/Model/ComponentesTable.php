<?php

namespace Componentes\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class ComponentesTable extends AbstractTableGateway {
    
    protected $table ='componentes';
    
    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Componentes());
        $this->initialize();
    }
    
    public function fetchAll(){
        $resultSet = $this->select();
        return $resultSet;
    }
}

