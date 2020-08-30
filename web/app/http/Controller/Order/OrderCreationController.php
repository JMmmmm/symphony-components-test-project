<?php
declare(strict_types=1);
namespace App\Http\Controller\Order;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderCreationController
{
    public function create(Request $request)
    {
        $test = 2;

        return new Response('<html><body>Hello '.'!</body></html>');
    }
}
