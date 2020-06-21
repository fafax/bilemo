<?php

namespace App\EventListener;


use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();

        //Construct error message

        try{
            $statusCode = $exception->getStatusCode();
        }
        catch(\Exception $e){
            $statusCode = 500;
        }


        $message = ["error" => [
            "message" => $exception->getMessage(),
            "Status code" => $statusCode
        ]];

        //format in json
        $data = $this->serializer->serialize($message, 'json');
        $response = new Response();
        $response->setContent($data);
        $response->headers->set('Content-Type', 'application/json');

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($statusCode);
            $response->headers->replace($exception->getHeaders());
        }else{
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        // sends the modified response object to the event
        $event->setResponse($response);
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException'
        );
    }
}