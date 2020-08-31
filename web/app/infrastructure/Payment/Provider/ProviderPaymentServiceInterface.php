<?php
declare(strict_types=1);
namespace App\Infrastructure\Payment\Provider;

use App\Infrastructure\Payment\Provider\DTO\PaymentRequestProviderDTO;

interface ProviderPaymentServiceInterface
{
    /**
     * @param PaymentRequestProviderDTO $paymentRequestProviderDTO
     */
    public function pay(PaymentRequestProviderDTO $paymentRequestProviderDTO): void;
}
