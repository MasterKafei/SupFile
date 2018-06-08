<?php

namespace AppBundle\Service\Business;


use AppBundle\Entity\File;
use AppBundle\Entity\User;
use AppBundle\Service\Util\AbstractContainerAware;

class UserBusiness extends AbstractContainerAware
{
    public function getCurrentUser()
    {
        return $this->container->get('security.token_storage')->getToken()->getUser();
    }

    public function getQuota(User $user)
    {
        $files = $this->container->get('doctrine')->getRepository(File::class)->findBy(array('owner' => $user));
        $quota = 0;
        $businessFile = $this->container->get('app.business.file');

        foreach ($files as $file) {
            $quota += intval((new \Symfony\Component\HttpFoundation\File\File($businessFile->getFilePath($file)))->getSize());
        }

        return round(($quota/(1000 * 1000)));
    }
}
