<?php

// module/Componentes/config/module.config.php:
return array(
    'controllers' => array(
        'invokables' => array(
            'Componentes\Controller\Componentes' => 'Componentes\Controller\ComponentesController',
        ),
    ),
    
    // La siguiente sección es nueva y debería ser añadida a tu fichero
    'router' => array(
        'routes' => array(
            'componentes' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/album[/:action][/:id]',
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
            'album' => __DIR__ . '/../view',
        ),
    ),
);

