<?php

namespace AppBundle\Service\Business;


use AppBundle\Entity\APIToken;
use AppBundle\Entity\File;
use AppBundle\Entity\Folder;
use AppBundle\Entity\User;
use AppBundle\Service\Util\AbstractContainerAware;
use Http\Client\Common\Exception\HttpClientNotFoundException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class APIBusiness extends AbstractContainerAware
{
    public function getAccessToken($login, $password)
    {
        $user = $this->isCredentialsValid($login, $password);

        if (!$user) {
            return null;
        }

        return $this->container->get('app.business.api_token')->getNewApiToken($user);
    }

    private function isCredentialsValid($login, $password)
    {
        /** @var User $user */
        $user = $this->container->get('doctrine')->getRepository(User::class)->findOneBy(array('email' => $login));

        if (null === $user) {
            throw new \RuntimeException('Bad credentials');
        }

        if ($this->container->get('security.password_encoder')->isPasswordValid($user, $password)) {
            return $user;
        }

        throw new \RuntimeException('Bad credentials');
    }

    public function createFolder(APIToken $token, $name, Folder $parent = null, $persist = true)
    {
        $folder = new Folder();

        $folder
            ->setParent($parent)
            ->setOwner($token->getUser())
            ->setName($name);

        if ($persist) {
            $em = $this->container->get('doctrine')->getManager();
            $em->persist($folder);
            $em->flush();
        }

        return $folder;
    }

    public function removeFolder(Folder $folder)
    {
        $em = $this->container->get('doctrine')->getManager();
        $em->remove($folder);
        $em->flush();
    }

    public function uploadFile(File $file, User $user, Folder $parent = null)
    {
        $file
            ->setOwner($user)
            ->setParent($parent);

        $em = $this->container->get('doctrine')->getManager();
        $em->persist($file);
        $em->flush();
    }

    public function removeFile(File $file)
    {
        $em = $this->container->get('doctrine')->getManager();
        $em->remove($file);
        $em->flush();
    }

    public function getUserNumber()
    {
        $users = $this->container->get('doctrine')->getRepository(User::class)->findAll();

        return count($users);
    }

    public function getUserInformation(APIToken $token)
    {
        return $token->getUser();
    }

    public function getFolderUserNumber(APIToken $token)
    {
        $folders = $this->container->get('doctrine')->getRepository(Folder::class)->findBy(array('user' => $token->getUser()));

        $count = count($folders);

        foreach ($folders as $folder) {
            if($folder instanceof File) {
                --$count;
            }
        }

        return $count;
    }

    public function getFolder(APIToken $token, $id)
    {
        $folder = $this->container->get('doctrine')->getRepository(Folder::class)->findOneBy(array('id' => $id, 'owner' => $token->getUser()));

        if ($folder instanceof File) {
            return null;
        }

        return $folder;
    }

    public function getFile(APIToken $token, $id)
    {
        return $this->container->get('doctrine')->getRepository(File::class)->findOneBy(array('id' => $id, 'owner' => $token->getUser()));
    }

    public function editFolder(Folder $folder, $name)
    {
        $folder->setName($name);

        $em = $this->container->get('doctrine')->getManager();
        $em->persist($folder);
        $em->flush();
    }

    public function getFolders(User $user, Folder $parent = null)
    {
        $folders = $this->container->get('doctrine')->getRepository(Folder::class)->findBy(array(
            'owner' => $user,
            'parent' => $parent,
        ));

        return $folders;
    }

    public function editFile(File $file, $name)
    {
        $file->setName($name);

        $em = $this->container->get('doctrine')->getManager();
        $em->persist($file);
        $em->flush();
    }

    public function getFiles(User $user, Folder $parent = null)
    {
        $files = $this->container->get('doctrine')->getRepository(File::class)->findBy(array(
            'parent' => $parent,
            'owner' => $user,
        ));

        return $files;
    }
}
