<?php

use App\Controller\HomeWorkController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes){
    $routes ->add('php_action', '/php')
        ->controller([HomeWorkController::class, 'phpAction']);
};
