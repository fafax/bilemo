<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AddProduitController extends AbstractController
{
    /**
     * @Route("/add/produit",name="add_produit",  methods={"POST"})
     */
    public function index(Request $request, EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $data = $request->getContent();
        $produit = $serializer->deserialize($data, 'App\Entity\Produit', 'json');

        $em->persist($produit);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }
}
