<?php

namespace AppBundle\Controller\API\File;


use AppBundle\Entity\File;
use AppBundle\Entity\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListingController extends Controller
{

    public function listFileAction($token, Folder $parent = null)
    {
        $apiToken = $this->get('app.business.api_token')->getApiToken($token);
        $this->get('app.business.folder')->isUserAllowedToManageFolder($parent, $apiToken->getUser());

        /** @var File[] $files */
        $files = $this->get('app.business.api')->getFiles($apiToken->getUser(), $parent);

        $response = array();

        foreach ($files as $file) {
            $response[] = array(
                'id' => $file->getId(),
                'name' => $file->getName(),
                'parent' => $file->getParent() === null ? null : $file->getParent()->getId(),
                'public_token' => $file->getPublicToken(),
            );
        }

        return new JsonResponse($response);
    }
}
