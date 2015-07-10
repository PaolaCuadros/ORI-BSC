<?php
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

$sql = 'INSERT INTO login (EMAIL, CONTRASENA) VALUES ("cuadros1605@gmail.com", "123456789")';
        $this->adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);