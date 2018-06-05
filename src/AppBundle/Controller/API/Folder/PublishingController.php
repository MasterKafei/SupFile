<?php

namespace AppBundle\Controller\API\Folder;


use AppBundle\Entity\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PublishingController extends Controller
{
    public function publishFolderAction($token, Folder $folder)
    {
        $apiToken = $this->get('app.business.api_token')->getApiToken($token);
        $this->get('app.business.folder')->isUserAllowedToManageFolder($folder, $apiToken->getUser());
        $this->get('app.business.folder')->makeFolderPublic($folder);

        return $this->redirectToRoute('app_api_folder_showing_show', array('token' => $token, 'folder' => $folder->getId()));
    }
}
