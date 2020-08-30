<?php
declare(strict_types=1);
namespace App\Application\Order\Specification;

use App\Domain\Entity\Order;

class OrderPaidSpecification
{
    /**
     * @param string $status
     * @return bool
     */
    public function isSatisfyBy(string $status): bool
    {
        return $status === Order::STATUS_PAID;
    }
}
