<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Presupuestado\Controller\Presupuestado' => 'Presupuestado\Controller\PresupuestadoController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'presupuestado' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/presupuestado[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Presupuestado\Controller\Presupuestado',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'presupuestado' => __DIR__ . '/../view',
        ),
    ),
);

