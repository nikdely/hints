<?php
/**
 * Created by PhpStorm.
 * User: Nikolay.Danilov
 * Date: 16.01.2019
 * Time: 9:28
 */

namespace Setting;

use \Bitrix\Main\Config\Option;

class Options
{
    protected static $module_id = 'module.setting';

    public static function getOption($option)
    {
        return Option::get(self::$module_id, $option);
    }
    /**
     * get environment status
     * @return string environment status
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     */
    public static function env()
    {
        return self::getOption("env");
    }

    /**
     * Получим условный параметр
     * остальные аналогично
     * @return string
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     */
    public static function functionBlock()
    {
        return self::getOption('functionBlock');
    }
}