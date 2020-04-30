<?php

namespace App\Controller\api\v1\Produit;

use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class AddProduitController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/api/v1/add/produit",name="add_produit",  methods={"POST"})
     */
    public function __invoke(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $data = $request->getContent();
        $produit = $serializer->deserialize($data, 'App\Entity\Produit', 'json');

        $errors = $validator->validate($produit);

        if (count($errors)) {
            foreach ($errors as $error) {
                echo $error->getMessage() . '<br>';
            }
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($produit);
        $em->flush();

        $response = new Response('Add produit', Response::HTTP_CREATED);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
