<?php
declare(strict_types=1);
namespace App\Http\Controller\Product;

use App\Application\TestService;
use App\Application\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsCreationController
{
    public function __construct(TestService $container, EntityManagerInterface $entityManager, UserInterface $user)
    {
        $test = 'sd';
    }


    public function create(Request $request)
    {
//        $test = new TestService();
//
//        $containerBuilder = new ContainerBuilder();
//
//
//        $test = $containerBuilder->get(TestService::class);

        return new Response('<html><body>Hello '.'!</body></html>');
    }
}
