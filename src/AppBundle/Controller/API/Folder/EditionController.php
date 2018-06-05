<?php

namespace AppBundle\Controller\API\Folder;


use AppBundle\Entity\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class EditionController extends Controller
{
    public function editFolderAction($token, Folder $folder, $name)
    {
        $apiToken = $this->get('app.business.api_token')->getApiToken($token);
        $this->get('app.business.folder')->isUserAllowedToManageFolder($folder, $apiToken->getUser());
        $this->get('app.business.api')->editFolder($folder, $name);

        return new JsonResponse('Folder edited with success');
    }
}
