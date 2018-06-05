<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 */
class User extends BaseUser implements UserInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    private $googleId;

    /**
     * @var string
     */
    private $facebookId;

    /**
     * @var Folder
     */
    private $folders;

    /**
     * @var APIToken
     */
    private $apiToken;

    /**
     * @var Offer
     */
    private $offer;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get googleId
     *
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Set googleId
     *
     * @param $googleId
     * @return $this
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;
        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set facebookId
     *
     * @param $facebookId
     * @return $this
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
        return $this;
    }

    /**
     * Get folders.
     *
     * @return Folder
     */
    public function getFolders()
    {
        return $this->folders;
    }

    /**
     * Set folders.
     *
     * @param $folders
     * @return $this
     */
    public function setFolders($folders)
    {
        $this->folders = $folders;
        return $this;
    }

    /**
     * Get apiToken.
     *
     * @return APIToken
     */
    public function getAPIToken()
    {
        return $this->apiToken;
    }

    /**
     * Set apiToken.
     *
     * @param $apiToken
     * @return $this
     */
    public function setAPIToken($apiToken)
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    /**
     * Get offer.
     *
     * @return Offer
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Set offer.
     *
     * @param Offer $offer
     * @return User $user
     */
    public function setOffer(Offer $offer)
    {
        $this->offer = $offer;

        return $this;
    }
}