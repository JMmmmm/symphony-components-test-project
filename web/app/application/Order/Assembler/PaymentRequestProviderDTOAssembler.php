<?php
declare(strict_types=1);
namespace App\Application\Order\Assembler;

use App\Application\User\UserInterface;
use App\Domain\Entity\Order;
use App\Infrastructure\Payment\Provider\DTO\PaymentRequestProviderDTO;

class PaymentRequestProviderDTOAssembler
{
    /**
     * @param Order $order
     * @param UserInterface $user
     * @return PaymentRequestProviderDTO
     */
    public function create(Order $order, UserInterface $user): PaymentRequestProviderDTO
    {
        return new PaymentRequestProviderDTO($user->getEmail(), $order->getBillingNumber(), $order->getTotalAmountSum());
    }
}
