<?php
declare(strict_types=1);
namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Application\User\UserInterface;
use App\Infrastructure\Doctrine\EntityManagerFactory;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;

/**
 * @param ContainerConfigurator $configurator
 */
return function(ContainerConfigurator $configurator) {
    $configurator->import('services/products_creation.php');
    $configurator->import('services/order_creation.php');
    $configurator->import('services/order_payment.php');

    $services = $configurator->services();

    $services
        ->set(EntityManagerInterface::class)
        ->factory([EntityManagerFactory::class, 'getInstance'])
        ->public();

    $services->set(UserInterface::class)
        ->synthetic();

    $services->set(Client::class, Client::class)->public();
};
