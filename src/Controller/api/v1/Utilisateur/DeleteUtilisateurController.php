<?php

namespace App\Controller\api\v1\Utilisateur;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;


class DeleteUtilisateurController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/api/v1/delete/utilisateur/{id}", name="delete_utilisateur" , methods={"DELETE"})
     *
     * @SWG\Response(
     *     response=204,
     *     description="delete one utilisateur",
     * )
     *
     * @SWG\Parameter(name="Authorization", in="header", required=true, type="string", default="Bearer accessToken", description="Authorization")
     *
     * @SWG\Tag(name="Utilisateur")
     */
    public function __invoke(Utilisateur $utilisateur, EntityManagerInterface $em, UserInterface $user)
    {

        if ($utilisateur->getClientId()->getId() == $user->getId()) {
            $em->remove($utilisateur);
            $em->flush();
            $response = new Response('', Response::HTTP_NO_CONTENT);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }


        $response = new Response('{"message":"Page not found "}', Response::HTTP_NOT_FOUND);
        $response->headers->set('Content-Type', 'application/json');
        return $response;


    }
}
