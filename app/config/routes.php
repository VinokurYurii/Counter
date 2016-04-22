<?php

return array(
    'home'           => array(
        'pattern'    => '/',
        'controller' => 'Blog\\Controller\\PostController',
        'action'     => 'index'
    ),
    'testredirect'   => array(
        'pattern'    => '/test_redirect',
        'controller' => 'Blog\\Controller\\TestController',
        'action'     => 'redirect',
    ),
    'test_json' => array(
        'pattern'    => '/test_json',
        'controller' => 'Blog\\Controller\\TestController',
        'action'     => 'getJson',
    ),
    'signin'         => array(
        'pattern'    => '/signin',
        'controller' => 'Blog\\Controller\\SecurityController',
        'action'     => 'signin'
    ),
    'login'          => array(
        'pattern'    => '/login',
        'controller' => 'Blog\\Controller\\SecurityController',
        'action'     => 'login'
    ),
    'logout'         => array(
        'pattern'    => '/logout',
        'controller' => 'Blog\\Controller\\SecurityController',
        'action'     => 'logout'
    ),
    'update_profile' => array(
        'pattern'       => '/profile',
        'controller'    => 'CMS\\Controller\\ProfileController',
        'action'        => 'update',
        '_requirements' => array(
            '_method' => 'POST'
        )
    ),
    'profile'        => array(
        'pattern'    => '/profile',
        'controller' => 'CMS\\Controller\\ProfileController',
        'action'     => 'get'
    ),
    'add_post'       => array(
        'pattern'    => '/posts/add',
        'controller' => 'Blog\\Controller\\PostController',
        'action'     => 'add',
        'security'   => array('ROLE_USER'),
    ),
    'show_post'      => array(
        'pattern'       => '/posts/{id}',
        'controller'    => 'Blog\\Controller\\PostController',
        'action'        => 'show',
        '_requirements' => array(
            'id' => '\d+'
        )
    ),
    'edit_post'      => array(
        'pattern'       => '/posts/{id}/edit',
        'controller'    => 'CMS\\Controller\\BlogController',
        'action'        => 'edit',
        '_requirements' => array(
            'id'      => '\d+',
            '_method' => 'POST'
        )

    ),
    'bills'         => array(
        'pattern'    => '/bills',
        'controller' => 'Accounter\\Controller\\BillController',
        'action'     => 'index',
        'security'   => array('ROLE_USER'),
    ),
    'show_bill_type'    => array(
        'pattern'  => '/bill_type/{id}',
        'controller'    => 'Accounter\\Controller\\BillController',
        'action'        => 'showBillType',
        '_requirements' => array(
            'id' => '\d+'
        ),
        'security'   => array('ROLE_USER'),
    ),
    'add_bill_type'    => array(
        'pattern'  => '/bill_type/add/{id}',
        'controller'    => 'Accounter\\Controller\\BillController',
        'action'        => 'addBillType',
        '_requirements' => array(
            'id' => '\d+'
        ),
        'security'   => array('ROLE_USER'),
    ),
    'add_bill_species'    => array(
        'pattern'  => '/bill_species/add/{id}',
        'controller'    => 'Accounter\\Controller\\BillController',
        'action'        => 'addSpecies',
        '_requirements' => array(
            'id' => '\d+'
        ),
        'security'   => array('ROLE_USER'),
    ),
    'show_bill_species'    => array(
        'pattern'  => '/bill_species/{id}',
        'controller'    => 'Accounter\\Controller\\BillController',
        'action'        => 'showSpecies',
        '_requirements' => array(
            'id' => '\d+'
        ),
        'security'   => array('ROLE_USER'),
    ),
    'ajax_receiver'    => array(
        'pattern'  => '/ajax_receiver',
        'controller'    => 'CMS\\Controller\\AjaxController',
        'action'        => 'handle',
        '_requirements' => array(
            '_method' => 'POST'
        ),
        'security'   => array('ROLE_USER'),
    ),
    'cms'    => array(
        'pattern'  => '/cms',
        'controller'    => 'CMS\\Controller\\CMSController',
        'action'        => 'index',
        'security'   => array('ROLE_ADMIN')
    ),
    'cms_model'    => array(
        'pattern'  => '/cms/{src}/{model}',
        'controller'    => 'CMS\\Controller\\CMSController',
        'action'        => 'display',
        '_requirements' => array(
            'src'   => '\w+',
            'model' => '\w+'
        ),
        'security'   => array('ROLE_ADMIN')
    )
);