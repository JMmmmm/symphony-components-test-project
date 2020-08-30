<?php
declare(strict_types=1);
namespace App\Http\Controller\Order;

use App\Application\Order\OrderCreationService;
use App\Http\Validation\RequestValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

class OrderCreationController
{
    use RequestValidator;

    /**
     * @var OrderCreationService
     */
    private OrderCreationService $orderCreationService;

    /**
     * OrderCreationController constructor.
     * @param OrderCreationService $orderCreationService
     */
    public function __construct(OrderCreationService $orderCreationService)
    {
        $this->orderCreationService = $orderCreationService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $constraints = new Collection([
            'products_ids' => new All([
                'constraints' => [new NotNull(), new Type('numeric')]
            ])
        ]);

        $this->validate($request, $constraints);

        $billingNumber = $this->orderCreationService->create($request->get('products_ids'));

        $data = [
            'success' => true,
            'billingNumber' => $billingNumber
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
