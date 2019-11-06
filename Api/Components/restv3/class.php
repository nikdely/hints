<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use ApiV3\Mapping;
use ApiV3\Config;

class RestV3Component extends \CBitrixComponent {



    /* @var ApiV3\Config */
	public $api;

	public function initData() {
		$this->arResult['api'] = $this->api = new Config($this->arParams['PATH']);
    }

    public function executeComponent() {
        $this->includeComponentLang('class.php');
        $this->initData();

        if (Mapping::MAP[$this->api->apiName]) {
            $notOrmClass = 'ApiV3\Modules\\' . Mapping::MAP[$this->api->apiName]['class'];
            $ormClass = 'ApiV3\OrmModules\\' . Mapping::MAP[$this->api->apiName]['class'];

            if (Mapping::MAP[$this->api->apiName]['custom'] == true && (class_exists($notOrmClass))) {
                $class = $notOrmClass;
            }
            else {
                $class = $ormClass;
            }

            $this->arResult['className'] = $class;

            // подключаем модуль
            if (Mapping::MAP[$this->api->apiName]['module']) {
                if (is_array(Mapping::MAP[$this->api->apiName]['module'])) {
                    foreach (Mapping::MAP[$this->api->apiName]['module'] as $key => $value) {
                        \CModule::IncludeModule(Mapping::MAP[$this->api->apiName]['module'][$key]);
                    }
                } else {
                    \CModule::IncludeModule(Mapping::MAP[$this->api->apiName]['module']);
                }
            }

            $this->arResult['class'] = $module = new $class($this->api, Mapping::MAP[$this->api->apiName]);
            if (!$module->isCorrectRequest()) {
                $this->arResult['response'] = $module->sendRequestError();
            }
            else {
                $this->arResult['response'] = $module->run();
            }
        }
        else {
            $class = 'ApiV3\Error';
            $this->arResult['class'] = $module = new $class($this->api, Mapping::MAP['error']);

            $this->arResult['response'] = $module->sendRequestError();

        }

        $this->includeComponentTemplate();
    }

}