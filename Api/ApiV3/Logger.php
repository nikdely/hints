<?php


namespace ApiV3;

use Log\Log;

/**
 * Для работы должен быть подключен и правильно настроен монолог
 *
 *
 * Class Logger
 * @package ApiV3
 */
class Logger
{

    public static function logEmpty($data, $config, $map, $status)
    {
        Log::getInstance('apiV3/'.str_replace('\\', '/', $map['class']), $config->action)->debug($status . ' ', array($data, $config, $map, $status));
    }

    public static function logError($data, $config, $map, $status)
    {
        Log::getInstance('apiV3/'.str_replace('\\', '/', $map['class']), $config->action)->error($status . ' ', array($data, $config, $map, $status));
    }

    public static function logAll($data, $config, $map, $status)
    {
        Log::getInstance('apiV3/'.str_replace('\\', '/', $map['class']), $config->action)->notice($status . ' ', array($data, $config, $map, $status));
    }
}