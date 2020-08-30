<?php
declare(strict_types=1);
namespace App\Http\Middleware;

use InvalidArgumentException;
use LogicException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $exceptionData = [
            'success'  => false,
            'message' => $exception->getMessage()
        ];

        switch (true) {
            case $exception instanceof InvalidArgumentException:
                $event->setResponse(new JsonResponse($exceptionData, Response::HTTP_UNPROCESSABLE_ENTITY));
                break;
            case $exception instanceof LogicException:
                $event->setResponse(new JsonResponse($exceptionData, Response::HTTP_SERVICE_UNAVAILABLE));
                break;
            default:
                $event->setResponse(new JsonResponse($exceptionData, Response::HTTP_INTERNAL_SERVER_ERROR));
        }
    }

    /**
     * @return array|string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException'
        ];
    }
}