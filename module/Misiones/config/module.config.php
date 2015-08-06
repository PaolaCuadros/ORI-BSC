<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Misiones\Controller\Misiones' => 'Misiones\Controller\MisionesController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'Misiones' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/Misiones[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Misiones\Controller\Misiones',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'Misiones' => __DIR__ . '/../view',
        ),
    ),
);

