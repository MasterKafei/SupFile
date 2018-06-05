<?php

namespace AppBundle\Controller\API\Folder;


use AppBundle\Entity\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreationController extends Controller
{
    public function createFolderAction($token, $name, Folder $parent = null)
    {
        $test = ($parent === null);
        $token = $this->get('app.business.api_token')->getApiToken($token);
        $this->get('app.business.folder')->isUserAllowedToManageFolder($parent, $token->getUser());
        $this->get('app.business.api')->createFolder($token, $name, $parent);

        return new JsonResponse('Folder created with success ' . $test);
    }
}
