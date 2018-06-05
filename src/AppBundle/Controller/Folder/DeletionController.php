<?php

namespace AppBundle\Controller\Folder;

use AppBundle\Entity\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DeletionController extends Controller
{
    public function deleteFolderAction(Folder $folder)
    {
        $this->get('app.business.folder')->isUserAllowedToManageFolder($folder);

        $em = $this->getDoctrine()->getManager();
        $em->remove($folder);
        $em->flush();


        if ($folder->getParent() !== null) {
            return $this->redirectToRoute('app_folder_showing_show', array('id' => $folder->getParent()->getId()));
        }

        return $this->redirectToRoute('app_folder_showing_show_root');
    }
}
