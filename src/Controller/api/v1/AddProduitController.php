<?php

namespace App\Controller\api\v1;

use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AddProduitController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/api/v1/add/produit",name="add_produit",  methods={"POST"})
     */
    public function index(Request $request, EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $data = $request->getContent();
        $produit = $serializer->deserialize($data, 'App\Entity\Produit', 'json');

        $em->persist($produit);
        $em->flush();

        $response = new Response('Add produit', Response::HTTP_CREATED);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
