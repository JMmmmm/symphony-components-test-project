<?php
declare(strict_types=1);
namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Application\User\UserInterface;
use App\Http\Controller\Order\OrderCreationController;
use App\Infrastructure\Doctrine\EntityManagerFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @param ContainerConfigurator $configurator
 */
return function(ContainerConfigurator $configurator) {
    $configurator->import('services/products_creation.php');

    $services = $configurator->services();

    $services
        ->set(EntityManagerInterface::class)
        ->factory([EntityManagerFactory::class, 'getInstance'])
        ->public();

    $services->set(UserInterface::class)
        ->synthetic();

    $services
        ->set(OrderCreationController::class, OrderCreationController::class)
        ->autowire()
        ->args([new Reference(EntityManagerInterface::class), new Reference(UserInterface::class)])
        ->public();
};
