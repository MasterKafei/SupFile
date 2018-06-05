<?php

namespace AppBundle\Entity;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File as HttpFile;

/**
 * File
 * @Vich\Uploadable
 */
class File extends Folder
{
    /**
     * @var string
     */
    private $pathName;

    /**
     * @var string
     */
    private $extension;

    /**
     * @Vich\UploadableField(mapping="files", fileNameProperty="pathName")
     * @var HttpFile
     */
    private $file;

    /**
     * Set pathName.
     *
     * @param $pathName
     * @return $this
     */
    public function setPathName($pathName)
    {
        $this->pathName = $pathName;
        return $this;
    }

    /**
     * Get pathName.
     *
     * @return string
     */
    public function getPathName()
    {
        return $this->pathName;
    }

    /**
     * Set extension.
     *
     * @param $extension
     * @return $this
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * Get extension.
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set file.
     *
     * @param HttpFile $file
     * @return $this
     */
    public function setFile(HttpFile $file)
    {
        $this->file = $file;
        if($file) {
            $this->setLastUpdate(new \DateTime());
            $this->setExtension($file->getExtension());
        }
        return $this;
    }

    /**
     * Get file.
     *
     * @return HttpFile
     */
    public function getFile()
    {
        return $this->file;
    }
}
