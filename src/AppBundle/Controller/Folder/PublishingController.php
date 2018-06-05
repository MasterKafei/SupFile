<?php

namespace AppBundle\Controller\Folder;


use AppBundle\Entity\File;
use AppBundle\Entity\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PublishingController extends Controller
{
    public function publishFolderAction(Folder $folder)
    {
        $folderBusiness = $this->get('app.business.folder');
        $folderBusiness->isUserAllowedToManageFolder($folder);

        $folderBusiness->makeFolderPublic($folder);

        if($folder instanceof File) {
            return $this->redirectToRoute('app_file_showing_show', array('id' => $folder->getId()));
        }

        return $this->redirectToRoute('app_folder_showing_show', array('id' => $folder->getId()));
    }
}
