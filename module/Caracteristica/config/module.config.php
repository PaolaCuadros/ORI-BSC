<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Caracteristica\Controller\Caracteristica' => 'Caracteristica\Controller\CaracteristicaController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            
            'caracteristica' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/caracteristica[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Caracteristica\Controller\Caracteristica',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'caracteristica' => __DIR__ . '/../view',
        ),
    ),
);

