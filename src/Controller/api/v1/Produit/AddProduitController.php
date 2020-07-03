<?php

namespace App\Controller\api\v1\Produit;

use App\Service\ValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use HttpException;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Produit;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;


class AddProduitController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/api/v1/produits",name="add_produit",  methods={"POST"})
     *
     * @SWG\Response(
     *     response=201,
     *     description="Add one produit",
     *     @SWG\Schema(
     *         @SWG\Items(ref=@Model(type=Produit::class))
     *     )
     * )
     *
     * @SWG\Parameter(name="Authorization", in="header", required=true, type="string", default="Bearer accessToken", description="Authorization")
     *
     *
     * @SWG\Tag(name="Produit")
     */
    public function __invoke(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorService $validator)
    {
        $data = $request->getContent();
        try{
            $produit = $serializer->deserialize($data, 'App\Entity\Produit', 'json');
        }
        catch(\Exception $e){
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($validator->validate($produit)) {
            return $validator->validate($produit);
        }

        $em->persist($produit);
        $em->flush();

        $response = new Response('Add produit', Response::HTTP_CREATED);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
