<?php

namespace AppBundle\Controller\File;

use AppBundle\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DeletionController extends Controller
{
    public function deleteFileAction(File $file) {
        $this->get('app.business.folder')->isUserAllowedToManageFolder($file);
        $parent = $file->getParent();
        $em = $this->getDoctrine()->getManager();
        $em->remove($file);
        $em->flush();

        if (null === $file->getParent()) {
            return $this->redirectToRoute('app_folder_showing_show_root');
        } else {
            return $this->redirectToRoute('app_folder_showing_show', array(
               'id' => $parent->getId(),
            ));
        }
    }
}
