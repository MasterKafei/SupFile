<?php

namespace AppBundle\Controller\API\File;


use AppBundle\Entity\File;
use AppBundle\Entity\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CreationController extends Controller
{
    public function createFileAction(Request $request, $token, $name, Folder $parent = null)
    {
        $apiToken = $this->get('app.business.api_token')->getApiToken($token);
        $this->get('app.business.folder')->isUserAllowedToManageFolder($parent, $apiToken->getUser());
        $uploadedFile = $request->files->get('file');

        if (null === $uploadedFile) {
            return new JsonResponse('No file uploaded');
        }

        $file = new File();
        $file
            ->setPathName($this->get('app.business.file')->saveFile($uploadedFile))
            ->setName($name);

        $this->get('app.business.api')->uploadFile($file, $apiToken->getUser(), $parent);

        return new JsonResponse('File uploaded with success ');
    }
}
