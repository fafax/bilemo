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

class ListProduitController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/api/v1/list/produit/page/{page}",name="list_produit" ,requirements={"page"="\d+"}, methods={"GET"})
     */
    public function __invoke(ProduitRepository $produitRepo, SerializerInterface $serializer, int $page = 0, PaginationService $pagination)
    {
        $page = $page * 5;
        $countProduit = count($produitRepo->findAll());
        $produits = $produitRepo->findBy([], null, 5, $page);


        foreach ($produits as $produit) {
            $urlDetail = $this->generateUrl('detail_produit', ['id' => $produit->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
            $produit->setUrlDetail($urlDetail);
        }

        $tabProduits = ["produits" => $produits];
        $tabProduits = array_merge($tabProduits, ["Add produit" => $this->generateUrl('add_produit', [], UrlGeneratorInterface::ABSOLUTE_URL)]);
        $tabProduits = array_merge($tabProduits, $pagination->linkPagination($page, $countProduit, 'list_produit'));

        $data = $serializer->serialize($tabProduits, 'json', SerializationContext::create()->setGroups(['list']));
        $response = new Response();
        $response->setContent($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}
