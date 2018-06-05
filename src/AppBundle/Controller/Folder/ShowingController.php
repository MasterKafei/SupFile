<?php

namespace AppBundle\Controller\Folder;

use AppBundle\Entity\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShowingController extends Controller
{
    public function showFolderAction(Folder $folder = null)
    {
        $this->get('app.business.folder')->isFolderAllowedToBeDisplay($folder);

        if ($folder === null) {
            $folders = $this->getDoctrine()->getRepository(Folder::class)
                ->findBy(array('parent' => null, 'owner' => $this->getUser()));
        } else {
            $folders = $folder->getChilds();
        }

        return $this->render('@Page/Folder/Showing/show.html.twig',
            array(
                'folder' => $folder,
                'folders' => $folders,
            ));
    }

    public function showPublicFolderAction(Folder $folder, $token)
    {
        $this->get('app.business.folder')->isFolderPubliclyAccessible($token, $folder);

        return $this->render('@Page/Folder/Showing/public.html.twig',
            array(
                'folder' => $folder,
                'token' => $token,
            ));
    }
}
