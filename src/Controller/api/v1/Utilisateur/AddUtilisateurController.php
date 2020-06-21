<?php

namespace App\Controller\api\v1\Utilisateur;

use App\Service\ValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Entity\Utilisateur;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;


class AddUtilisateurController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/api/v1/add/utilisateur", name="add_utilisateur" , methods={"POST"})
     *
     * @SWG\Response(
     *     response=201,
     *     description="Add one utilisateur",
     *     @SWG\Schema(
     *         @SWG\Items(ref=@Model(type=Utilisateur::class))
     *     )
     * )
     *
     * @SWG\Parameter(name="Authorization", in="header", required=true, type="string", default="Bearer accessToken", description="Authorization")
     *
     *
     * @SWG\Tag(name="Utilisateur")
     */
    public function __invoke(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, UserInterface $user, ValidatorService $validator)
    {
        $data = $request->getContent();
        try{
            $utilisateur = $serializer->deserialize($data, 'App\Entity\Utilisateur', 'json');
        }
        catch(\Exception $e){
            throw new BadRequestHttpException($e->getMessage());
        }

        $utilisateur->setClientId($user);

        if ($validator->validate($utilisateur)) {
            return $validator->validate($utilisateur);
        }

        $em->persist($utilisateur);
        $em->flush();

        $response = new Response('Add utilisateur', Response::HTTP_CREATED);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
