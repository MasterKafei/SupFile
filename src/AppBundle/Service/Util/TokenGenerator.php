<?php

namespace AppBundle\Service\Util;

class TokenGenerator
{
    /**
     * Generate a random token
     *
     * @param null $length
     *
     * @return string
     */
    public function generateToken($length = null)
    {
        if (null === $length) {
            $hash = hash('sha256', uniqid(mt_rand(), true), true);

            return rtrim(strtr(base64_encode($hash), '+/', '-_'), '=');
        } else {
            $randomBase = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            $token = '';

            for ($i = 0; $i < $length; ++$i) {
                $token .= $randomBase[rand(0, strlen($randomBase) - 1)];
            }

            return $token;
        }
    }
}
