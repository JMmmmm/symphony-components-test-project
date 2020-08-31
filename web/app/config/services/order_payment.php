<?php
declare(strict_types=1);
namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Application\Order\Assembler\PaymentRequestProviderDTOAssembler;
use App\Application\Order\OrderPaymentService;
use App\Application\Order\Specification\OrderPaidSpecification;
use App\Application\Order\Specification\CorrectOrderTotalAmountSumSpecification;
use App\Application\User\UserInterface;
use App\Http\Controller\Order\OrderPaymentController;
use App\Infrastructure\Payment\Provider\ProviderPaymentServiceInterface;
use App\Infrastructure\Payment\Provider\YandexProvider\Hydrator\PaymentRequestHydrator;
use App\Infrastructure\Payment\Provider\YandexProvider\YandexPaymentService;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;

/**
 * @param ContainerConfigurator $configurator
 */
return function (ContainerConfigurator $configurator) {
    $services = $configurator->services();

    $services
        ->set(OrderPaymentController::class, OrderPaymentController::class)
        ->args([service(OrderPaymentService::class)])
        ->public();

    $services
        ->set(OrderPaymentService::class, OrderPaymentService::class)
        ->args([
            service(CorrectOrderTotalAmountSumSpecification::class),
            service(EntityManagerInterface::class),
            service(UserInterface::class),
            service(ProviderPaymentServiceInterface::class),
            service(PaymentRequestProviderDTOAssembler::class),
            service(OrderPaidSpecification::class),
        ])
        ->public();

    $services->set(CorrectOrderTotalAmountSumSpecification::class, CorrectOrderTotalAmountSumSpecification::class)->public();

    $services->set(OrderPaidSpecification::class, OrderPaidSpecification::class)->public();

    $services->set(PaymentRequestProviderDTOAssembler::class, PaymentRequestProviderDTOAssembler::class)->public();

    $services
        ->set(ProviderPaymentServiceInterface::class, YandexPaymentService::class)
        ->args([service(PaymentRequestHydrator::class), service(Client::class)])
        ->public();

    $services->set(PaymentRequestHydrator::class, PaymentRequestHydrator::class)->public();
};
