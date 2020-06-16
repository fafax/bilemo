<?php

namespace App\Controller\api\v1\Token;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;


class LoginCheckController extends AbstractController
{
    /**
     * @Route("/api/v1/login_check",name="login_check", methods={"GET"})
     *
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return Token",
     * )
     *
     * @SWG\Parameter(
     *       name="body",
     *       in="body",
     *       description="json order object",
     *       type="json",
     *       required=true,
     *      @SWG\Schema(
     *              @SWG\Property(
     *                  property="username",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="password",
     *                  type="string"
     *              )
     *          )
     *     ),
     *
     * @SWG\Tag(name="Token")
     */

    public function __invoke()
    {

        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}
