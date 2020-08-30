<?php
declare(strict_types=1);
namespace App\Application\Order;

use App\Application\Order\Assembler\PaymentRequestProviderDTOAssembler;
use App\Application\Order\Specification\OrderPaidSpecification;
use App\Application\Order\Specification\CorrectOrderTotalAmountSumSpecification;
use App\Application\User\UserInterface;
use App\Domain\Entity\Order;
use App\Infrastructure\Payment\Provider\ProviderPaymentServiceInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;

class OrderPaymentService
{
    /**
     * @var CorrectOrderTotalAmountSumSpecification
     */
    private CorrectOrderTotalAmountSumSpecification $correctOrderTotalAmountSumSpecification;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var UserInterface
     */
    private UserInterface $user;

    /**
     * @var ProviderPaymentServiceInterface
     */
    private ProviderPaymentServiceInterface $providerPaymentService;

    /**
     * @var PaymentRequestProviderDTOAssembler
     */
    private PaymentRequestProviderDTOAssembler $paymentRequestProviderDTOAssembler;

    /**
     * @var OrderPaidSpecification
     */
    private OrderPaidSpecification $orderPaidSpecification;

    /**
     * OrderPaymentService constructor.
     * @param CorrectOrderTotalAmountSumSpecification $correctOrderTotalAmountSumSpecification
     * @param EntityManagerInterface $entityManager
     * @param UserInterface $user
     * @param ProviderPaymentServiceInterface $providerPaymentService
     * @param PaymentRequestProviderDTOAssembler $paymentRequestProviderDTOAssembler
     * @param OrderPaidSpecification $orderPaidSpecification
     */
    public function __construct(
        CorrectOrderTotalAmountSumSpecification $correctOrderTotalAmountSumSpecification,
        EntityManagerInterface $entityManager,
        UserInterface $user,
        ProviderPaymentServiceInterface $providerPaymentService,
        PaymentRequestProviderDTOAssembler $paymentRequestProviderDTOAssembler,
        OrderPaidSpecification $orderPaidSpecification
    ) {
        $this->correctOrderTotalAmountSumSpecification = $correctOrderTotalAmountSumSpecification;
        $this->entityManager = $entityManager;
        $this->user = $user;
        $this->providerPaymentService = $providerPaymentService;
        $this->paymentRequestProviderDTOAssembler = $paymentRequestProviderDTOAssembler;
        $this->orderPaidSpecification = $orderPaidSpecification;
    }

    /**
     * @param string $billingNumber
     * @param float $receivedOrderTotalAmountSum
     */
    public function payOrder(string $billingNumber, float $receivedOrderTotalAmountSum): void
    {
        /** @var Order|null $order */
        $order = $this->entityManager
            ->getRepository(Order::class)
            ->findOneBy(['billingNumber' => $billingNumber]);

        if ($order === null) {
            throw new InvalidArgumentException('Order with billing number #' . $billingNumber . ' is absent');
        }

        if ($this->orderPaidSpecification->isSatisfyBy($order->getStatus())) {
            throw new InvalidArgumentException('Order with billing number #' . $billingNumber . ' is already paid');
        }

        if (!$this->correctOrderTotalAmountSumSpecification->isSatisfyBy($order->getTotalAmountSum(), $receivedOrderTotalAmountSum)) {
            throw new InvalidArgumentException('Received order total amount sum is incorrect of order with billing number #' . $billingNumber);
        }

        $paymentRequestDTO = $this->paymentRequestProviderDTOAssembler->create($order, $this->user);

        $this->providerPaymentService->pay($paymentRequestDTO);

        $this->updateOrder($order);
    }

    /**
     * @param Order $order
     */
    private function updateOrder(Order $order): void
    {
        $order
            ->setStatus(Order::STATUS_PAID)
            ->setUpdated(new DateTime());

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }
}
