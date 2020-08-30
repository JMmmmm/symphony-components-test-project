<?php
declare(strict_types=1);
namespace App\Http\Controller\Order;


use App\Application\TestService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController
{
    public function create(Request $request, TestService $testService)
    {
        $test = 2;

        return new Response('<html><body>Hello '.'!</body></html>');
    }
}
