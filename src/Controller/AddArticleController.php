<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AddArticleController extends AbstractController
{
    /**
     * @Route("/add/article",name="add_article",  methods={"POST"})
     */
    public function index(Request $request, EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $data = $request->getContent();
        $article = $serializer->deserialize($data, 'App\Entity\Article', 'json');

        $em->persist($article);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }
}
