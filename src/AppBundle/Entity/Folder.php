<?php

namespace AppBundle\Entity;

/**
 * Folder
 */
class Folder
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $publicToken;

    /**
     * @var User
     */
    private $owner;

    /**
     * @var Folder
     */
    private $parent;

    /**
     * @var Folder[]
     */
    private $childs;

    /**
     * @var \DateTime
     */
    private $lastUpdate;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Folder
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set publicToken.
     *
     * @param string|null $publicToken
     *
     * @return Folder
     */
    public function setPublicToken($publicToken = null)
    {
        $this->publicToken = $publicToken;

        return $this;
    }

    /**
     * Get publicToken.
     *
     * @return string|null
     */
    public function getPublicToken()
    {
        return $this->publicToken;
    }

    /**
     * Get owner.
     *
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set owner.
     *
     * @param User $owner
     * @return $this
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return Folder
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set parent.
     *
     * @param $parent
     * @return Folder
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Folder[]
     */
    public function getChilds()
    {
        return $this->childs;
    }

    /**
     * Set childs
     *
     * @param Folder[] $childs
     * @return Folder
     */
    public function setChilds($childs)
    {
        $this->childs = $childs;
        return $this;
    }

    /**
     * Get lastUpdate.
     *
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Set lastUpdate.
     *
     * @param \DateTime $lastUpdate
     * @return $this
     */
    public function setLastUpdate(\DateTime $lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
        return $this;
    }
}
