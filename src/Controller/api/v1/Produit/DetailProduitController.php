<?php

namespace App\Controller\api\v1\Produit;

use App\Entity\Produit;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;


class DetailProduitController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/api/v1/detail/produit/{id}", name="detail_produit" , methods={"GET"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return one produit",
     *     @SWG\Schema(
     *         @SWG\Items(ref=@Model(type=Produit::class))
     *     )
     * )
     *
     * @SWG\Parameter(name="Authorization", in="header", required=true, type="string", default="Bearer accessToken", description="Authorization")
     *
     * @SWG\Tag(name="Produit")
     */
    public function __invoke(Produit $produit, SerializerInterface $serializer)
    {
        $data = $serializer->serialize($produit, 'json', SerializationContext::create()->setGroups(['detail']));

        $response = new Response();
        $response->setContent($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
