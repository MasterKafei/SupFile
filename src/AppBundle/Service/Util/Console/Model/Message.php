<?php

namespace AppBundle\Service\Util\Console\Model;

/**
 * Class Message
 * @package AppBundle\Service\Util\Console\Model
 */
class Message
{
    const TYPE_SUCCESS = 'success';
    const TYPE_INFO = 'info';
    const TYPE_WARNING = 'warning';
    const TYPE_DANGER = 'danger';

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $type;

    /**
     * Message constructor.
     *
     * @param string $text
     * @param string $type
     */
    public function __construct($text, $type = self::TYPE_INFO)
    {
        $this->setText($text)->setType($type);
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
