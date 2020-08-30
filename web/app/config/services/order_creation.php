<?php
declare(strict_types=1);
namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Application\Order\OrderCreationService;
use App\Application\Product\ProductsCreationService;
use App\Application\User\UserInterface;
use App\Http\Controller\Order\OrderCreationController;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @param ContainerConfigurator $configurator
 */
return function(ContainerConfigurator $configurator) {
    $services = $configurator->services();

    $services
        ->set(OrderCreationController::class, OrderCreationController::class)
        ->args([service(OrderCreationService::class)])
        ->public();

    $services
        ->set(OrderCreationService::class, OrderCreationService::class)
        ->args([service(EntityManagerInterface::class), service(UserInterface::class)])
        ->public();
};
