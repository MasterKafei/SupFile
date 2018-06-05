<?php

namespace AppBundle\Extension\Twig;

class InstanceOfExtension extends \Twig_Extension
{
    public function getTests() {
        return array(
            new \Twig_SimpleTest('instanceof', array($this, 'isInstanceOf')),
        );
    }

    public function isInstanceOf($instance, $class) {
        $reflexion = new \ReflectionClass($class);
        return $reflexion->isInstance($instance);
    }
}
