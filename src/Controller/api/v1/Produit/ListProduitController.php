<?php

namespace App\Controller\api\v1\Produit;

use App\Repository\ProduitRepository;
use App\Service\PaginationService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

class ListProduitController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/api/v1/list/produit/page/{page}",name="list_produit" ,requirements={"page"="\d+"}, methods={"GET"})
     * List the rewards of the specified user.
     *
     * This call takes into account all confirmed awards, but not pending or refused awards.
     *
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of produit",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Produit::class, groups={"list"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     description="One page contains 5 products"
     * )
     * @SWG\Tag(name="Produit")
     * @Security(name="Bearer")
     */

    public function __invoke(ProduitRepository $produitRepo, SerializerInterface $serializer, int $page = 1, PaginationService $pagination)
    {
        $entityPerPage = 5;
        $countProduit = count($produitRepo->findAll());
        $produits = $produitRepo->findBy([], null, $entityPerPage, $page * $entityPerPage - $entityPerPage);


        foreach ($produits as $produit) {
            $urlDetail = $this->generateUrl('detail_produit', ['id' => $produit->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
            $produit->setUrlDetail($urlDetail);
        }

        $tabProduits = ["produits" => $produits];
        $tabProduits = array_merge($tabProduits, ["Add produit" => $this->generateUrl('add_produit', [], UrlGeneratorInterface::ABSOLUTE_URL)]);
        $tabProduits = array_merge($tabProduits, $pagination->linkPagination($page, $countProduit, 'list_produit', $entityPerPage));

        $data = $serializer->serialize($tabProduits, 'json', SerializationContext::create()->setGroups(['list']));
        $response = new Response();
        $response->setContent($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}
