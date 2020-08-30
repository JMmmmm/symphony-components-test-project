<?php
declare(strict_types=1);
namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Application\Product\ProductsCreationService;
use App\Application\User\UserInterface;
use App\Http\Assembler\Product\ProductDTOsAssembler;
use App\Http\Controller\Product\ProductsCreationController;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @param ContainerConfigurator $configurator
 */
return function(ContainerConfigurator $configurator) {
    $services = $configurator->services();

    $services
        ->set(ProductsCreationController::class, ProductsCreationController::class)
        ->args([service(ProductDTOsAssembler::class), service(ProductsCreationService::class)])
        ->public();

    $services->set(ProductDTOsAssembler::class, ProductDTOsAssembler::class)->public();

    $services
        ->set(ProductsCreationService::class, ProductsCreationService::class)
        ->args([service(EntityManagerInterface::class), service(UserInterface::class)])
        ->public();
};
