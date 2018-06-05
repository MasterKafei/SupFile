<?php

namespace AppBundle\Controller\API\User;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShowingController extends Controller
{
    public function showUserAction($token)
    {
        $apiToken = $this->get('app.business.api_token')->getApiToken($token);

        if (null === $apiToken) {
            return new JsonResponse('Invalid token');
        }

        $user = $apiToken->getUser();

        return new JsonResponse(
            array(
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
            )
        );
    }
}
