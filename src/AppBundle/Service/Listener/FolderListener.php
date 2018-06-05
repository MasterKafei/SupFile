<?php

namespace AppBundle\Service\Listener;

use AppBundle\Entity\Folder;
use Doctrine\ORM\Event\LifecycleEventArgs;

class FolderListener
{
    public function prePersist(Folder $folder)
    {
        $this->updateLastUpdate($folder);
    }

    public function preUpdate(Folder $folder)
    {
        $this->updateLastUpdate($folder);
    }

    private function updateLastUpdate(Folder $folder)
    {
        $folder->setLastUpdate(new \DateTime());
    }
}
