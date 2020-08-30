<?php
declare(strict_types=1);

use App\Http\Controller\Order\OrderCreationController;
use App\Http\Controller\Product\ProductsCreationController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

/**
 * @param RoutingConfigurator $routes
 */
return function (RoutingConfigurator $routes) {
    $routes->add('products_creation', '/products/create')
        ->controller([ProductsCreationController::class, 'create'])
        ->methods(['POST']);

    $routes->add('order_creation', '/order/create')
        ->controller([OrderCreationController::class, 'create'])
        ->methods(['POST']);
};