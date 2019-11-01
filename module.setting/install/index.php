<?php

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

class module_setting extends \CModule
{
    public $MODULE_ID ='module.setting';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $PARTNER_NAME;

    function __construct()
    {
        $this->MODULE_NAME = 'Настройки';
        $this->MODULE_DESCRIPTION = 'Для настроек неуникальных в разных средах';
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = 'module';
        $this->MODULE_VERSION = '1.0.0';
        $this->MODULE_VERSION_DATE = '2019-10-17 22:54:56';
    }

/**
     * Install the module
     */
    public function DoInstall() {
        if (!$this->InstallDB() || !$this->InstallEvents() || !$this->InstallFiles()) {
            return;
        }

        RegisterModule($this->MODULE_ID);        
    }

    /**
     * Uninstall the module
     */
    public function DoUninstall() {
        if (!$this->UnInstallDB() || !$this->UnInstallEvents() || !$this->UnInstallFiles()) {
            return;
        }
        UnRegisterModule($this->MODULE_ID);
        COption::RemoveOption($this->MODULE_ID);
    }

    /**
     * Install Events
     *
     * @return bool
     */
    public function InstallEvents() {
        return true;
    }

    /**
     * Uninstall Events
     *
     * @return bool
     */
    public function UnInstallEvents() {
        return true;
    }

    /**
     * Install Files
     *
     * @return bool
     */
    public function InstallFiles() {
        return true;
    }

    /**
     * Uninstall Files
     *
     * @return bool
     */
    public function UnInstallFiles() {
        return true;
    }

    /**
     * Add tables to the database
     *
     * @return bool
     */
    public function InstallDB() {
        return true;
    }

    /**
     * Remove the tables from the database
     *
     * @return bool
     */
    public function UnInstallDB() {
        return true;
    }

}