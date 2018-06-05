<?php

namespace AppBundle\Extension\Twig;


class MimeTypeExtension extends \Twig_Extension
{
    private static $supportedImageMimeType = array(
        'image/gif',
        'image/png',
        'image/jpeg',
        'image/bmp',
        'image/webp',
    );

    private static $supportedVideoMimeType = array(
        'video/mp4',
        'video/ogg',
        'video/webm',
    );

    private static $supportedAudioMimeType = array(
        'audio/mpeg',
        'audio/ogg',
        'audio/wav',
        'audio/mp3',
        'application/octet-stream',
    );

    private static $supportedTextMimeType = array(
        'text/plain',
    );

    public function getTests()
    {
        return array(
            new \Twig_SimpleTest('image', array($this, 'isImage')),
            new \Twig_SimpleTest('video', array($this, 'isVideo')),
            new \Twig_SimpleTest('audio', array($this, 'isAudio')),
            new \Twig_SimpleTest('text', array($this, 'isText')),
        );
    }

    public function isImage($filePath)
    {
        return in_array(self::getMimeType($filePath), self::$supportedImageMimeType);
    }

    public function isVideo($filePath)
    {
        return in_array(self::getMimeType($filePath), self::$supportedVideoMimeType);
    }

    public function isAudio($filePath)
    {
        return in_array(self::getMimeType($filePath), self::$supportedAudioMimeType);
    }

    public function isText($filePath)
    {
        return in_array(self::getMimeType($filePath), self::$supportedTextMimeType);
    }

    private static function getMimeType($filePath)
    {
        return mime_content_type($filePath);
    }
}
