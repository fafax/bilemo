<?php

namespace App\Controller\api\v1\Produit;

use App\Repository\ProduitRepository;
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
     * @Route("/api/v1/list/produit/{page}",name="list_produit" ,requirements={"page"="\d+"}, methods={"GET"})
     */
    public function __invoke(ProduitRepository $produitRepo, SerializerInterface $serializer, int $page = 0)
    {
        $countProduit = count($produitRepo->findAll());
        $produits = $produitRepo->findBy([], null, 5, $page);


        foreach ($produits as $produit) {
            $urlDetail = $this->generateUrl('detail_produit', ['id' => $produit->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
            $produit->setUrlDetail($urlDetail);
        }

        $produits = array_merge($produits, ["Add produit" => $this->generateUrl('add_produit', [], UrlGeneratorInterface::ABSOLUTE_URL)]);
        $produits = array_merge($produits, $this->linkPagination($page, $countProduit));

        $data = $serializer->serialize($produits, 'json', SerializationContext::create()->setGroups(['list']));
        $response = new Response();
        $response->setContent($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    private function linkPagination($page, $totalPrduit)
    {
        $numberPage;
        $tabLinkPagignation = [];

        if ($page > 0) {
            $tabLinkPagignation = array_merge($tabLinkPagignation, ["Previous page" => $this->generateUrl('list_produit', ["page" => $numberPage = $page - 5], UrlGeneratorInterface::ABSOLUTE_URL)]);
        }
        if ($page + 5 <= $totalPrduit) {
            $tabLinkPagignation = array_merge($tabLinkPagignation, ["Next page" => $this->generateUrl('list_produit', ["page" => $numberPage = $page + 5], UrlGeneratorInterface::ABSOLUTE_URL)]);
        }

        return $tabLinkPagignation;
    }
}
