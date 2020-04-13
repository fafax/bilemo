<?php

namespace App\Controller\api\v1\Utilisateur;

use App\Entity\Utilisateur;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


class DetailUtilisateurController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/api/v1/detail/utilisateur/{id}", name="detail_utilisateur" , methods={"GET"})
     */
    public function __invoke(Utilisateur $utilisateur, SerializerInterface $serializer, UserInterface $user)
    {


        if ($utilisateur->getClientId()->getId() == $user->getId()) {
            $response = new Response();
            $data = $serializer->serialize($utilisateur, 'json', SerializationContext::create()->setGroups(['detail']));
            $response->setContent($data);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        $response = new Response('{"message":"Page not found "}', Response::HTTP_NOT_FOUND);
        return $response;

    }
}
