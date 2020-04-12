<?php

namespace App\Controller\api\v1;

use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


class AddUtilisateurController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/api/v1/add/utilisateur", name="add_utilisateur" , methods={"POST"})
     */
    public function index(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, UserInterface $user)
    {
        $data = $request->getContent();
        $utilisateur = $serializer->deserialize($data, 'App\Entity\Utilisateur', 'json');
        $utilisateur->setClientId($user);
        $em->persist($utilisateur);
        $em->flush();
        $response = new Response('Add utilisateur', Response::HTTP_CREATED);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
