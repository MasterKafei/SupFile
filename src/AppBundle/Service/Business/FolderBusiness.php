<?php

namespace AppBundle\Service\Business;

use AppBundle\Entity\File;
use AppBundle\Entity\Folder;
use AppBundle\Entity\User;
use AppBundle\Service\Util\AbstractContainerAware;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FolderBusiness extends AbstractContainerAware
{
    /**
     * Does the folder content can be display
     *
     * @param Folder $folder
     * @param User $user
     * @param string|null $token
     * @return bool
     */
    public function isFolderDisplayable(Folder $folder = null, User $user = null, $token = null)
    {
        if($this->isRootFolder($folder)) {
            return true;
        }

        if (null === $user) {
            $user = $this->container->get('app.business.user')->getCurrentUser();
        }

        return
            !$this->isFolderAFile($folder) &&
            (
                $this->isUserFolderOwner($user, $folder) ||
                $this->isTokenFolderValid($folder, $token)
            );
    }

    public function isRootFolder(Folder $folder = null)
    {
        return null === $folder;
    }

    /**
     * Is current user the owner of this file
     *
     * @param Folder $folder
     * @return bool
     */
    public function isCurrentUserFolderOwner(Folder $folder) {
        return $this->isUserFolderOwner($this->container->get('app.business.user')->getCurrentUser(), $folder);
    }

    /**
     * Is given user the owner of this file
     *
     * @param User $user
     * @param Folder $folder
     * @return bool
     */
    public function isUserFolderOwner(User $user, Folder $folder = null) {

        if (null === $folder) {
            return true;
        }

        return $folder->getOwner() === $user && null !== $user;
    }

    /**
     * Is given token same as the one of the folder
     *
     * @param Folder $folder
     * @param string $token
     * @return bool
     */
    public function isTokenFolderValid(Folder $folder, $token) {
        return $folder->getPublicToken() === $token;
    }

    /**
     * Is the folder a file
     *
     * @param Folder $folder
     * @return bool
     */
    public function isFolderAFile(Folder $folder) {
        return $folder instanceof File;
    }

    /**
     * Make the folder public by generate a token
     *
     * @param Folder $folder
     * @param bool $persist
     * @return string
     */
    public function makeFolderPublic(Folder $folder, $persist = true)
    {
        $token = $this->container->get('app.util.token_generator')->generateToken();

        $folder->setPublicToken($token);

        if ($persist) {
            /** @var EntityManagerInterface $em */
            $em = $this->container->get('doctrine')->getManager();
            $em->persist($folder);
            $em->flush();
        }

        return $token;
    }

    /**
     * Check if the current folder is accessible by given token
     *
     * @param $token
     * @param Folder $folder
     * @return bool
     */
    public function isFolderPubliclyAccessible($token, Folder $folder)
    {
        if ($folder === null) {
           return false;
        }

        return $this->isTokenFolderValid($folder, $token) || $this->isFolderPubliclyAccessible($token, $folder->getParent());
    }

    /**
     * Is user is able to manage folder
     *
     * @param Folder $folder
     * @param User|null $user
     * @return bool
     */
    public function doesUserCanManageFolder(Folder $folder = null, User $user = null)
    {
        if (null === $user) {
            $user = $this->container->get('app.business.user')->getCurrentUser();
        }
        return $this->isUserFolderOwner($user, $folder);
    }

    /**
     * Check user folder manager permission
     *
     * @param User $user
     * @param Folder $folder
     */
    public function isUserAllowedToManageFolder(Folder $folder = null, User $user = null)
    {
        if(!$this->doesUserCanManageFolder($folder, $user)) {
            throw new AccessDeniedHttpException();
        }
    }

    /**
     * Check if the folder can be display for a user
     *
     * @param Folder|null $folder
     * @param User|null $user
     * @param null $token
     */
    public function isFolderAllowedToBeDisplay(Folder $folder = null, User $user = null, $token = null)
    {
        if(!$this->isFolderDisplayable($folder, $user, $token)) {
            throw new NotFoundHttpException();
        }
    }

    public function isPublicFolderAllowedToBeDisplay(Folder $folder, $token)
    {
        if(!$this->isFolderPubliclyAccessible($token, $folder)) {
            throw new NotFoundHttpException();
        }
    }

    public function convertFolderToZip(Folder $folder)
    {
        if($folder instanceof File)
        {
            return $this->container->get('app.business.file');
        }

        $zip = new \ZipArchive();
        $zipName = $folder->getName();
        $zip->open($zipName, \ZipArchive::CREATE);
        $this->folderToZip($folder, $zip, '');
        $zip->close();
        return $zip;
    }

    private function folderToZip(Folder $folder, \ZipArchive $zip, $currentFolderName)
    {
        $fileBusiness = $this->container->get('app.business.file');
        foreach ($folder->getChilds() as $child) {
            if ($child instanceof File) {
                $zip->addFromString($currentFolderName . $child->getName(), file_get_contents($fileBusiness->getFilePath($child)));
            } else {
                $subFolder = $currentFolderName . $child->getName() . '/';
                $zip->addEmptyDir($subFolder);
                $this->folderToZip($child, $zip, $subFolder);
            }
        }
    }
}