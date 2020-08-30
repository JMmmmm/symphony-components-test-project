<?php
declare(strict_types=1);

use App\Http\Controller\Order\OrderController;
use App\Http\Controller\Product\ProductsCreationController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('products_creation', '/products/create')
        ->controller([ProductsCreationController::class, 'create'])
        ->methods(['GET']);

    $routes->add('order_creation', '/order/create')
        ->controller([OrderController::class, 'create'])
        ->methods(['GET']);
};