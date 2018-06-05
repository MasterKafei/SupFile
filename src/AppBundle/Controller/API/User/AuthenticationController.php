<?php

namespace AppBundle\Controller\API\User;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthenticationController extends Controller
{
    public function authenticateAction(Request $request)
    {
        $login = $request->query->get('login');
        $password = $request->query->get('password');

        if (null === $login || null === $password) {
           return new JsonResponse(array(
               'error' => 'Missing login or password'
           ));
        }

        $apiToken = $this->get('app.business.api')->getAccessToken($login, $password);

        return new JsonResponse(array(
            'token' => $apiToken->getToken(),
        ));
    }
}
