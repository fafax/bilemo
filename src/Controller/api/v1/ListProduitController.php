<?php

namespace App\Controller\api\v1;

use App\Repository\ProduitRepository;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListProduitController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/api/v1/list/produit",name="list_produit" , methods={"GET"})
     */
    public function index(ProduitRepository $produitRepo, SerializerInterface $serializer)
    {

        $produits = $produitRepo->findAll();

        foreach ($produits as $produit) {
            $url = $this->generateUrl('detail_produit', ['id' => $produit->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
            $produit->setUrlDetail($url);
        }

        $data = $serializer->serialize($produits, 'json', SerializationContext::create()->setGroups(['list']));

        $response = new Response();
        $response->setContent($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
