<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Componentes\Controller\Componentes' => 'Componentes\Controller\ComponentesController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'componentes' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/componentes[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Componentes\Controller\Componentes',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'componentes' => __DIR__ . '/../view',
        ),
    ),
);

