<?php
return array(
    'controllers' => array(
        'factories' => array(
            'BsConversation\Controller\Index' => 'BsConversation\Controller\Factory\IndexControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'bs-conversation' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/conversation',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'BsConversation\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'unsubscribe' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/unsubscribe/:conversation/:email',
                            'constraints' => array(
                                'conversation' => '[a-zA-Z0-9]*',
                                'email'     => '[a-zA-Z0-9_.@-]*',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'BsConversation\Controller',
                                'controller'    => 'Index',
                                'action'        => 'unsubscribeConversation',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'BsConversation' => __DIR__ . '/../view',
        ),
    ),
    'service_manager' => [
        'aliases' => [
            'odm' => 'doctrine.documentmanager.odm_default'
        ],
        'factories' => [
            'bsconversation_options' => 'BsConversation\\Options\\Factory\\OptionsFactory',
            'bsconversation_transport_smtp' => 'BsConversation\\Transport\\Factory\SMTPTransportFactory',
            'bsconversation_plugin_unsubscribe_url' => 'BsConversation\\Plugin\\Factory\UnsubscribeUrlFactory',
            'bsconversation_service' => 'BsConversation\\Service\\Factory\\ConversationServiceFactory',
        ],
        'invokables'=>[
            'bsconversation_events' => 'BsConversation\Event\Manager',
        ]
    ]
);
