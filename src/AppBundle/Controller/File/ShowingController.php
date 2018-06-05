<?php

namespace AppBundle\Controller\File;

use AppBundle\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShowingController extends Controller
{
    public function showFileAction(File $file)
    {
        $this->get('app.business.file')->isUserAllowedToDisplayFile($file);

        return $this->render('@Page/File/Showing/show.html.twig',
            array(
               'file' => $file,
            ));
    }

    public function showPublicFileAction(File $file, $token)
    {
        $this->get('app.business.folder')->isPublicFolderAllowedToBeDisplay($file, $token);

        return $this->render('@Page/File/Showing/public.html.twig',
            array(
                'file' => $file,
                'token' => $token,
            ));
    }
}
