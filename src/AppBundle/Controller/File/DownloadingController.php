<?php

namespace AppBundle\Controller\File;


use AppBundle\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DownloadingController extends Controller
{
    public function downloadFileAction(File $file)
    {
        $this->get('app.business.file')->isUserAllowedToDownloadFile($file);

        $path = $this->get('app.business.file')->getFilePath($file);

        return $this->file($path, $file->getName(), ResponseHeaderBag::DISPOSITION_INLINE);
    }

    public function downloadPublicFileAction(File $file, $token)
    {
        $this->get('app.business.folder')->isPublicFolderAllowedToBeDisplay($file, $token);

        $path = $this->get('app.business.file')->getFilePath($file);

        return $this->file($path, $file->getName(), ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
