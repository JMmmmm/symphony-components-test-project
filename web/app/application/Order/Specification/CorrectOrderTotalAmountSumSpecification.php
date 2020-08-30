<?php
declare(strict_types=1);
namespace App\Application\Order\Specification;

class CorrectOrderTotalAmountSumSpecification
{
    /**
     * @param float $orderTotalAmountSum
     * @param float $receivedTotalAmountSum
     * @return bool
     */
    public function isSatisfyBy(float $orderTotalAmountSum, float $receivedTotalAmountSum): bool
    {
        return $orderTotalAmountSum === $receivedTotalAmountSum;
    }
}
