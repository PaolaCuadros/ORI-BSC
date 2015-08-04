<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Observaciones\Controller\Observaciones' => 'Observaciones\Controller\ObservacionesController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'observaciones' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/observaciones[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Observaciones\Controller\Observaciones',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'Observaciones' => __DIR__ . '/../view',
        ),
    ),
);


