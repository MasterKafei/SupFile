<?php

namespace AppBundle\Service\Security;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class UserProvider extends FOSUBUserProvider implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        try {
            return parent::loadUserByOAuthUserResponse($response);
        } catch(AccountNotLinkedException $e) {

            $email = $response->getEmail();

            $user = $this->userManager->findUserByEmail($email);
            if (null === $user) {
               $user = new User();
            }

            $id = $response->getUsername();
            $nickname = $response->getNickname();

            $user
                ->setEmail($email)
                ->setUsername($nickname)
                ->setEnabled(true);

            switch($response->getResourceOwner()->getName())
            {
                case('google_owners'):
                    $user->setGoogleId($id);
                    break;

                case('facebook_owners'):
                    $user->setFacebookId($id);
                    break;
            }

            $factory = $this->container->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword(md5(uniqid()), $user->getSalt());
            $user->setPassword($password);

            /** @var $entityManager EntityManagerInterface */
            $entityManager = $this->container->get('doctrine')->getManager();

            $entityManager->persist($user);
            $entityManager->flush();

            return $user;
        }
    }
}
