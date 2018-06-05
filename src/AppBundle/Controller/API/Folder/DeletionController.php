<?php

namespace AppBundle\Controller\API\Folder;


use AppBundle\Entity\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeletionController extends Controller
{
    public function deleteFolderAction($token, Folder $folder)
    {
        $apiToken = $this->get('app.business.api_token')->getApiToken($token);
        $this->get('app.business.folder')->isUserAllowedToManageFolder($folder, $apiToken->getUser());
        $this->get('app.business.api')->removeFolder($folder);

        return new JsonResponse('Folder deleted with success');
    }
}
