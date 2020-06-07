<?php


namespace Ohooki\LFMail;

/**
 * Class Mail
 * @package Ohooki\LFMail
 * LFMAIL facade
 */
class Mail
{

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * LFMail facade function
     */
    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([new LFMAIL(), $name], $arguments);
    }

}
