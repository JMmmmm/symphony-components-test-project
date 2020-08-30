<?php
declare(strict_types=1);
namespace App\Http\Controller\Order;

use App\Application\Order\OrderPaymentService;
use App\Http\Validation\RequestValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

class OrderPaymentController
{
    use RequestValidator;

    /**
     * @var OrderPaymentService
     */
    private OrderPaymentService $orderPaymentService;

    /**
     * OrderPaymentController constructor.
     * @param OrderPaymentService $orderPaymentService
     */
    public function __construct(OrderPaymentService $orderPaymentService)
    {
        $this->orderPaymentService = $orderPaymentService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function pay(Request $request): JsonResponse
    {
        $constraints = new Collection([
            'billingNumber' => [new NotNull(), new Type('string')],
            'orderTotalAmountSum' => [new NotNull(), new Type('numeric')]
        ]);

        $this->validate($request, $constraints);

        $this->orderPaymentService->payOrder($request->get('billingNumber'), (float)$request->get('orderTotalAmountSum'));

        return new JsonResponse(['success' => true], Response::HTTP_OK);
    }
}
