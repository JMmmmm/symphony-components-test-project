<?php
declare(strict_types=1);
namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Application\User\UserInterface;
use App\Http\Controller\Order\OrderController;
use App\Http\Controller\Product\ProductsCreationController;
use App\Application\TestService;
use App\Infrastructure\Doctrine\EntityManagerFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\Request;

return function(ContainerConfigurator $configurator) {
    $services = $configurator->services();

    $services->set(Request::class, Request::class);

    $services
        ->set(EntityManagerInterface::class)
        ->factory([EntityManagerFactory::class, 'getInstance'])
        ->public();

    $services->set(UserInterface::class)
        ->synthetic();

    $services->set(TestService::class, TestService::class)->public();

    $services
        ->set(ProductsCreationController::class, ProductsCreationController::class)
        ->args([service(TestService::class), service(EntityManagerInterface::class), service(UserInterface::class)])
        ->public();

    $services
        ->set(OrderController::class, OrderController::class)
        ->autowire()
        ->args([service(TestService::class), new Reference(EntityManagerInterface::class), new Reference(UserInterface::class)])
        ->public();
};
