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

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;


class DetailUtilisateurController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/api/v1/utilisateur/{id}", name="detail_utilisateur" , methods={"GET"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return one utilisateur",
     *     @SWG\Schema(
     *         @SWG\Items(ref=@Model(type=Utilisateur::class))
     *     )
     * )
     *
     * @SWG\Parameter(name="Authorization", in="header", required=true, type="string", default="Bearer accessToken", description="Authorization")
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     required=true,
     *     description="Retrieves utilisateur information based on its id"
     * )
     *
     * @SWG\Tag(name="Utilisateur")
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
