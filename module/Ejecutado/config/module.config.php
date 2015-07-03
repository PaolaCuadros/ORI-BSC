<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Ejecutado\Controller\Ejecutado' => 'Ejecutado\Controller\EjecutadoController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'ejecutado' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/ejecutado[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ejecutado\Controller\Ejecutado',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'ejecutado' => __DIR__ . '/../view',
        ),
    ),
);

