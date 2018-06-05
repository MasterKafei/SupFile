<?php

namespace AppBundle\Controller\Folder;


use AppBundle\Entity\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DownloadingController extends Controller
{
    public function downloadAction(Folder $folder)
    {
        $zip = $this->get('app.business.folder')->convertFolderToZip($folder);

        $response = new Response(file_get_contents($folder->getName()));
        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $folder->getName() . '.zip"');
        $response->headers->set('Content-length', filesize($folder->getName()));

        return $response;
    }
}
