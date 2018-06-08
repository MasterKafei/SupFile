<?php

namespace AppBundle\Service\Listener;


use AppBundle\Entity\Offer;
use AppBundle\Entity\User;
use AppBundle\Service\Util\AbstractContainerAware;
use Doctrine\ORM\Event\LifecycleEventArgs;

class UserListener extends AbstractContainerAware
{
    public function prePersist(User $user, LifecycleEventArgs $args)
    {
        $offer = $this->container->get('doctrine')->getRepository(Offer::class)->findOneBy(array('price' => 0));
        $user->setOffer($offer);
    }
}
