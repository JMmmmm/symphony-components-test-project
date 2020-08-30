<?php
declare(strict_types=1);
namespace App\Infrastructure\Payment\Provider\YandexProvider\Hydrator;

use App\Infrastructure\Payment\Provider\DTO\PaymentRequestProviderDTO;

class PaymentRequestHydrator
{
    /**
     * @param PaymentRequestProviderDTO $paymentRequestProviderDTO
     * @return array
     */
    public function extract(PaymentRequestProviderDTO $paymentRequestProviderDTO): array
    {
        return [
            'user_email' => $paymentRequestProviderDTO->getUserEmail(),
            'order_id' => $paymentRequestProviderDTO->getBillingNumber(),
            'order_sum' => $paymentRequestProviderDTO->getOrderTotalSum(),
        ];
    }
}
