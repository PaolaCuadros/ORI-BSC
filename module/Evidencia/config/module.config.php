<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Evidencia\Controller\Evidencia' => 'Evidencia\Controller\EvidenciaController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'evidencia' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/evidencia[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Evidencia\Controller\Evidencia',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'Evidencia' => __DIR__ . '/../view',
        ),
    ),
);

