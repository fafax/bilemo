<?php

namespace App\Controller\api;

use App\Entity\Produit;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DetailProduitController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/api/v1/detail/produit/{id}", name="detail_produit" , methods={"GET"})
     */
    public function index(Produit $produit, SerializerInterface $serializer)
    {
        $data = $serializer->serialize($produit, 'json', SerializationContext::create()->setGroups(['detail']));

        $response = new Response();
        $response->setContent($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
