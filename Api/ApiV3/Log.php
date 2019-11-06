<?php


namespace ApiV3;

use Monolog\Handler\StreamHandler;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\WebProcessor;
use Setting\Options;
use Bitrix\Main\Loader;

class Log
{
    const BASE_PATH = '/path/to/log/'; // абсолютный путь от корня файловой системы
    const BASE_PATH_DEV = '/path/to/log/';

    /**
     * предполагается, что есть модуль настроек
     * @return string
     */
    static protected function getBasPath()
    {
        Loader::includeModule('module.setting');

        $basePath = self::BASE_PATH;

        if (Options::env() == 'DEV') {
            $basePath = self::BASE_PATH_DEV;
        }

        return $basePath;
    }

    protected static $instances = array();

    /**
     * @param string $path
     * @param string $name
     * @return Logger
     */
    static function getInstance($path, $name)
    {
        $path = trim($path, '/');

        $basePath = self::getBasPath();

        if (!isset(self::$instances[$name])) {
            $log = new Logger('');

            $log->pushHandler(new StreamHandler($basePath . '/' . $path . '/' . $name . '.debug.log', Logger::DEBUG, false));
            $log->pushHandler(new StreamHandler($basePath . '/' . $path . '/' . $name . '.info.log', Logger::INFO, false));
            $log->pushHandler(new StreamHandler($basePath . '/' . $path . '/' . $name . '.notice.log', Logger::NOTICE, false));
            $log->pushHandler(new StreamHandler($basePath . '/' . $path . '/' . $name . '.warning.log', Logger::WARNING, false));
            $log->pushHandler(new StreamHandler($basePath . '/' . $path . '/' . $name . '.error.log', Logger::ERROR, false));

            $processors = array(
                new MemoryUsageProcessor(),
                new IntrospectionProcessor(),
                new WebProcessor(),
            );

            $log->pushProcessor(function ($record) use ($processors) {
//				if ($record['level'] >= Logger::WARNING) {
                foreach ($processors as $processor) {
                    $record = $processor($record);
                }
//				}

                return $record;
            });

            self::$instances[$name] = $log;
        }
        return self::$instances[$name];
    }

    protected function __construct()
    {
    }

    /**
     * для быстрой отладки
     */
    static function log_array() {
        $arArgs = func_get_args();
        $sResult = '';
        foreach($arArgs as $arArg) {
            $sResult .= "\n\n".print_r($arArg, true);
        }

        if(!defined('LOG_FILENAME')) {
            define('LOG_FILENAME', $_SERVER['DOCUMENT_ROOT'].'/_s/log.txt');
        }
        AddMessage2Log($sResult, 'log_array -> ');
    }
}