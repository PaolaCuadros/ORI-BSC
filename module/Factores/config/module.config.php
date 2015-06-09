<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Factores\Controller\Factores' => 'Factores\Controller\FactoresController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
//            'factores' => array(
//                'type'    => 'segment',
//                'options' => array(
//                    'route'    => '/factores[/:action][/:id]',
//                    'constraints' => array(
//                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                        'id'     => '[0-9]+',
//                    ),
//                    'defaults' => array(
//                        'controller' => 'Factores\Controller\Factores',
//                        'action'     => 'indexvv',
//                    ),
//                ),
//            ),
            
            'factores' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/factores[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Factores\Controller\Factores',
                        'action'     => 'index',
                    ),
                ),
            ),
            
            
//            'add' => array(
//                'type'    => 'segment',
//                'options' => array(
//                    'route'    => '/factores[/:action][/:id]',
//                    'constraints' => array(
//                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                        'id'     => '[0-9]+',
//                    ),
//                    'defaults' => array(
//                        'controller' => 'Factores\Controller\Factores',
//                        'action'     => 'add',
//                    ),
//                ),
//            ),
            
//            'sumar' => array(
//                'type'    => 'segment',
//                'options' => array(
//                    'route'    => '/factores[/:action][/:id]',
//                    'constraints' => array(
//                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                        'id'     => '[0-9]+',
//                    ),
//                    'defaults' => array(
//                        'controller' => 'Factores\Controller\Factores',
//                        'action'     => 'add',
//                    ),
//                ),
//            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'factores' => __DIR__ . '/../view',
        ),
    ),
);

