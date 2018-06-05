<?php

namespace AppBundle\Controller\API\Folder;


use AppBundle\Entity\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShowingController extends Controller
{
    public function showFolderAction($token, Folder $folder)
    {
        $apiToken = $this->get('app.business.api_token')->getApiToken($token);
        $this->get('app.business.folder')->isUserAllowedToManageFolder($folder, $apiToken->getUser());

        return new JsonResponse(
            array(
                'id' => $folder->getId(),
                'name' => $folder->getName(),
                'public_token' => $folder->getPublicToken(),
                'parent' => $folder->getParent() === null ? null : $folder->getParent()->getId(),
            )
        );
    }
}
