<?php

namespace AppBundle\Controller\API\File;


use AppBundle\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class EditionController extends Controller
{

    public function editFileAction($token, File $file, $name)
    {
        $apiToken = $this->get('app.business.api_token')->getApiToken($token);
        $this->get('app.business.folder')->isUserAllowedToManageFolder($file, $apiToken->getUser());
        $this->get('app.business.api')->editFile($file, $name);

        return new JsonResponse('File edited with success');
    }
}
