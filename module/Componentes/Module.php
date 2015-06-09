<?php

namespace Componentes;

class Module {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '\config\module.config.php';
    }

    // getAutoloaderConfig() and getConfig() methods here
    // Add this method:
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Componentes\Model\ComponentesTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new Model\ComponentesTable($dbAdapter);
                    return $table;
                },
            ),
        );
    }

}

