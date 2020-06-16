<?php


namespace App\Service;

use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorService
{
    private $validator;
    private $serializer;

    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function validate($entity)
    {
        $errors = $this->validator->validate($entity);

        if (count($errors)) {
            $tabErrors = [];
            foreach ($errors as $error) {
                array_push($tabErrors, $error->getMessage());
            }
            $dataError = $this->serializer->serialize($errors, 'json');

            $response = new Response();
            $response->setContent($dataError);
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            return null;
        }
    }
}