<?php

namespace AppBundle\Controller\Folder;

use AppBundle\Entity\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ListingController extends Controller
{
    public function listFolderAction()
    {
        $folders = $this->getDoctrine()->getRepository(Folder::class)->findBy(array('owner' => $this->getUser()));

        return $this->render('@Page/Folder/Listing/list.html.twig',
            array(
               'folders' => $folders,
            ));
    }
}
