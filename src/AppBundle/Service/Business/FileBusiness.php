<?php

namespace AppBundle\Service\Business;

use AppBundle\Entity\File;
use AppBundle\Entity\User;
use AppBundle\Service\Util\AbstractContainerAware;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileBusiness extends AbstractContainerAware
{

    /**
     * Can user download the given file
     *
     * @param User $user
     * @param File $file
     * @param string|null $token
     * @return bool
     */
    public function canUserDownloadFile(File $file, User $user = null, $token = null)
    {
        return $this->canUserDisplayFile($file, $user, $token);
    }

    /**
     * Is user allowed to download the given file
     *
     * @param File $file
     * @param User|null $user
     */
    public function isUserAllowedToDownloadFile(File $file, User $user = null)
    {
        if (null === $user) {
            $user = $this->container->get('app.business.user')->getCurrentUser();
        }

        if(!$this->canUserDisplayFile($file, $user)) {
            throw new AccessDeniedHttpException();
        }
    }

    public function isUserAllowedToDisplayFile(File $file, User $user = null)
    {
        if (null === $user) {
            $user = $this->container->get('app.business.user')->getCurrentUser();
        }

        if(!$this->canUserDisplayFile($file, $user)) {
            throw new AccessDeniedHttpException();
        }
    }

    /**
     * Can user display given file
     *
     * @param User $user
     * @param File $file
     * @param string|null $token
     * @return bool
     */
    public function canUserDisplayFile(File $file, User $user = null, $token = null)
    {
        if ($user === $file->getOwner()) {
           return true;
        }

        return $this->isTokenValid($file, $token);
    }

    /**
     * Is token same as the one of given the file
     *
     * @param File $file
     * @param string $token
     * @return bool
     */
    public function isTokenValid(File $file, $token)
    {
        if (null === $token) {
           return false;
        }

        return $file->getPublicToken() === $token;
    }

    public function isUserAllowedToAccessFileByToken(File $file, $token)
    {
        if (!$this->isTokenValid($file, $token)) {
            throw new NotFoundHttpException();
        }
    }

    public function getFilePath(File $file)
    {
        return $this->container->getParameter('file_path') . $file->getPathName();
    }

    public function saveFile(\Symfony\Component\HttpFoundation\File\File $file)
    {
        $name = md5(uniqid()) . '.' . $file->guessExtension();

        $file->move(
            $this->container->getParameter('file_path'),
            $name
        );

        return $name;
    }
}
