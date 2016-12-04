<?php

namespace Utils;

/**
 * Contains all of the basic clients information functions.
 * Class Client
 * @package Utils
 */
class Client
{

    /**
     * Gets the clients IP address.
     * @return string
     */
    public static function getIPAddress() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}