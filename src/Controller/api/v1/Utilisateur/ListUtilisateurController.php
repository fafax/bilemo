<?php

namespace App\Controller\api\v1\Utilisateur;


use App\Repository\UtilisateurRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ListUtilisateurController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/api/v1/list/utilisateur",name="list_utilisateur" , methods={"GET"})
     */
    public function __invoke(UtilisateurRepository $utilisateurRepo, SerializerInterface $serializer, UserInterface $user)
    {
        $utilisateurs = $utilisateurRepo->findBy(array('clientId' => $user->getId()));

        foreach ($utilisateurs as $utilisateur) {
            $url = $this->generateUrl('detail_utilisateur', ['id' => $utilisateur->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
            $utilisateur->setUrlDetail($url);
        }

        $data = $serializer->serialize($utilisateurs, 'json', SerializationContext::create()->setGroups(['list']));
        $response = new Response();
        $response->setContent($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
