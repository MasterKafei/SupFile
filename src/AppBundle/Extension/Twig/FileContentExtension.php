<?php

namespace AppBundle\Extension\Twig;


class FileContentExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_Function('getFileContent', array($this, 'getFileContent')),
        );
    }

    public function getFileContent($filePath)
    {
        return file_get_contents($filePath);
    }
}
