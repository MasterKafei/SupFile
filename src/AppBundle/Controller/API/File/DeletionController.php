<?php

namespace AppBundle\Controller\API\File;


use AppBundle\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeletionController extends Controller
{
    public function deleteFileAction($token, File $file)
    {
        $apiToken = $this->get('app.business.api_token')->getApiToken($token);
        $this->get('app.business.folder')->isUserAllowedToManageFolder($file, $apiToken->getUser());
        $this->get('app.business.api')->removeFile($file);

        return new JsonResponse('File deleted with success');
    }
}
