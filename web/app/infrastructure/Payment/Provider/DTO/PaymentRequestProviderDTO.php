<?php
declare(strict_types=1);
namespace App\Infrastructure\Payment\Provider\DTO;

class PaymentRequestProviderDTO
{
    /**
     * @var string
     */
    private string $userEmail;

    /**
     * @var string
     */
    private string $billingNumber;

    /**
     * @var float
     */
    private float $orderTotalSum;

    /**
     * PaymentRequestProviderDTO constructor.
     * @param string $userEmail
     * @param string $billingNumber
     * @param float $orderTotalSum
     */
    public function __construct(string $userEmail, string $billingNumber, float $orderTotalSum)
    {
        $this->userEmail = $userEmail;
        $this->billingNumber = $billingNumber;
        $this->orderTotalSum = $orderTotalSum;
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    /**
     * @return string
     */
    public function getBillingNumber(): string
    {
        return $this->billingNumber;
    }

    /**
     * @return float
     */
    public function getOrderTotalSum(): float
    {
        return $this->orderTotalSum;
    }
}
