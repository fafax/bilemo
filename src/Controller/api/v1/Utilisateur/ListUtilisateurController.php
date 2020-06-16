<?php

namespace App\Controller\api\v1\Utilisateur;


use App\Repository\UtilisateurRepository;
use App\Service\PaginationService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Entity\Utilisateur;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class ListUtilisateurController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/api/v1/list/utilisateur/page/{page}",name="list_utilisateur", requirements={"page"="\d+"}, methods={"GET"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of utiliateur",
     *     @SWG\Schema(
     *         @SWG\Items(ref=@Model(type=Utilisateur::class))
     *     )
     * )
     *
     * @SWG\Parameter(name="Authorization", in="header", required=true, type="string", default="Bearer accessToken", description="Authorization")
     *
     * @SWG\Parameter(
     *     name="page",
     *     in="path",
     *     type="integer",
     *     required=true,
     *     description="One page contains 5 utilisateurs"
     * )
     *
     * @SWG\Tag(name="Utilisateur")
     */

    public function __invoke(UtilisateurRepository $utilisateurRepo, SerializerInterface $serializer, UserInterface $user, int $page = 1, PaginationService $pagination)
    {

        $entityPerPage = 5;
        $countUtilisateur = count($utilisateurRepo->findBy(array('clientId' => $user->getId())));
        $utilisateurs = $utilisateurRepo->findBy(array('clientId' => $user->getId()), null, $entityPerPage, $page * $entityPerPage - $entityPerPage);

        foreach ($utilisateurs as $utilisateur) {
            $urlDetail = $this->generateUrl('detail_utilisateur', ['id' => $utilisateur->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
            $utilisateur->setUrlDetail($urlDetail);
            $urlDelete = $this->generateUrl('delete_utilisateur', ['id' => $utilisateur->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
            $utilisateur->setUrlDelete($urlDelete);
        }
        $tabUtilisateurs = ["Utilisateurs" => $utilisateurs];
        $tabUtilisateurs = array_merge($tabUtilisateurs, ["Add utilisateur" => $this->generateUrl('add_utilisateur', [], UrlGeneratorInterface::ABSOLUTE_URL)]);
        $tabUtilisateurs = array_merge($tabUtilisateurs, $pagination->linkPagination($page, $countUtilisateur, 'list_utilisateur', $entityPerPage));

        $data = $serializer->serialize($tabUtilisateurs, 'json', SerializationContext::create()->setGroups(['list']));

        $response = new Response();
        $response->setContent($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}
