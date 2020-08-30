<?php
declare(strict_types=1);
namespace App\Infrastructure\Payment\Provider\YandexProvider;

use App\Infrastructure\Payment\Provider\DTO\PaymentRequestProviderDTO;
use App\Infrastructure\Payment\Provider\ProviderPaymentServiceInterface;
use App\Infrastructure\Payment\Provider\YandexProvider\Hydrator\PaymentRequestHydrator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use LogicException;
use Symfony\Component\HttpFoundation\Response;

class YandexPaymentService implements ProviderPaymentServiceInterface
{
    private const API_URL = 'https://ya.ru';

    /**
     * @var PaymentRequestHydrator
     */
    private PaymentRequestHydrator $paymentRequestHydrator;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * YandexPaymentService constructor.
     * @param PaymentRequestHydrator $paymentRequestHydrator
     * @param Client $client
     */
    public function __construct(PaymentRequestHydrator $paymentRequestHydrator, Client $client)
    {
        $this->paymentRequestHydrator = $paymentRequestHydrator;
        $this->client = $client;
    }

    /**
     * @param PaymentRequestProviderDTO $paymentRequestProviderDTO
     * @throws GuzzleException
     */
    public function pay(PaymentRequestProviderDTO $paymentRequestProviderDTO): void
    {
        $requestData = $this->paymentRequestHydrator->extract($paymentRequestProviderDTO);

        $response = $this->client->request('GET', self::API_URL, [$requestData]);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new LogicException('Payment service now is not available');
        }
    }
}
