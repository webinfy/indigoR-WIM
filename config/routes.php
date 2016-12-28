<?php

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::defaultRouteClass('DashedRoute');

Router::prefix('admin', function ($routes) {
    $routes->connect('/', ['controller' => 'Users', 'action' => 'dashboard']);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);

    $routes->fallbacks('DashedRoute');
});

Router::scope('/', function (RouteBuilder $routes) {

    $routes->connect('/', ['controller' => 'Users', 'action' => 'home']);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
    $routes->connect('/recharge', ['controller' => 'Users', 'action' => 'cardRegister']);

    $routes->connect('/agent-authentication', ['controller' => 'Users', 'action' => 'agentAuthentication']);
    $routes->connect('/authentication-failure', ['controller' => 'Users', 'action' => 'authenticationFailure']);
    $routes->connect('/naviator-status', ['controller' => 'Users', 'action' => 'naviatorStatus']);
    //$routes->connect('/edit-card', ['controller' => 'Users', 'action' => 'editCard']);

    $routes->fallbacks('DashedRoute');
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
