<?php

namespace AppBundle\Controller\API\Folder;


use AppBundle\Entity\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListingController extends Controller
{
    public function listFolderAction($token, Folder $parent = null)
    {
        $apiToken = $this->get('app.business.api_token')->getApiToken($token);
        $this->get('app.business.folder')->isUserAllowedToManageFolder($parent, $apiToken->getUser());
        $folders = $this->get('app.business.api')->getFolders($apiToken->getUser(), $parent);

        $response = array();

        /** @var Folder $folder */
        foreach ($folders as $folder) {
            $response[] = array(
                'id' => $folder->getId(),
                'name' => $folder->getName(),
                'public_token' => $folder->getPublicToken(),
                'parent' => $folder->getParent() === null ? null : $folder->getParent()->getId(),
            );
        }

        return new JsonResponse($response);
    }
}
