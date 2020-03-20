<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListArticleController extends AbstractController
{
    /**
     * @Route("/list/article",name="list_article" , methods={"GET"})
     */
    public function index(ArticleRepository $articleRepo, SerializerInterface $serializer)
    {
        $articles = $articleRepo->findAll();

        $data = $serializer->serialize($articles, 'json');

        $response = new Response();
        $response->setContent($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
