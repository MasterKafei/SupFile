<?php

namespace AppBundle\Service\Business;


use AppBundle\Service\Util\AbstractContainerAware;

class UserBusiness extends AbstractContainerAware
{
    public function getCurrentUser()
    {
        return $this->container->get('security.token_storage')->getToken()->getUser();
    }
}
