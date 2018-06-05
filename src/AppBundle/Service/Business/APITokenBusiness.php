<?php

namespace AppBundle\Service\Business;

use AppBundle\Entity\APIToken;
use AppBundle\Entity\User;
use AppBundle\Service\Util\AbstractContainerAware;

class APITokenBusiness extends AbstractContainerAware
{
    public function getNewApiToken(User $user, $persist = true)
    {
        $apiToken = $user->getAPIToken();

        if (null === $apiToken) {
            $apiToken = new APIToken();
            $apiToken->setUser($user);
        }

        $apiToken->setToken($this->container->get('app.util.token_generator')->generateToken());

        if ($persist) {
           $em = $this->container->get('doctrine')->getManager();
           $em->persist($apiToken);
           $em->flush();
        }

        return $apiToken;
    }

    /**
     * Get ApiToken User
     *
     * @param string $token
     * @return ApiToken
     */
    public function getApiToken($token)
    {
        $apiToken = $this->container->get('doctrine')
            ->getRepository(APIToken::class)
            ->findOneBy(array('token' => $token));
        return $apiToken;
    }
}