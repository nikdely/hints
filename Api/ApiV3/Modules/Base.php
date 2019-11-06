<?php

namespace ApiV3\Modules;

use ApiV3\Api;
use ApiV3\Mapping;

class Base extends Api
{
    /**
     * Метод GET
     * Вывод списка всех записей
     * @return string
     */
    public function indexAction()
    {
        $class = 'ApiV3\OrmModules\\' . Mapping::MAP[$this->config->apiName]['class'];
        $base = new $class($this->config, Mapping::MAP[$this->config->apiName]);
        return $base->viewAction();
    }
	
	 /**
     * Метод GET
     * Просмотр текущей записи
     * @param null $id
     * @return string
     */
	
	public function viewCurrentAction()
    {
        $class = 'ApiV3\OrmModules\\' . Mapping::MAP[$this->config->apiName]['class'];
        $base = new $class($this->config, Mapping::MAP[$this->config->apiName]);
        return $base->viewCurrentAction();
	}
	

    /**
     * Метод GET
     * Просмотр отдельной записи (по id)
     * @return string
     */
    public function viewAction()
    {
        /**
         * заглушка для просмотра
         * если не переопределено в дочернем классе, то переадресует запрос ORM-классу
         */

        $class = 'ApiV3\OrmModules\\' . Mapping::MAP[$this->config->apiName]['class'];
        $base = new $class($this->config, Mapping::MAP[$this->config->apiName]);
        return $base->viewAction();
    }

    /**
     * Метод POST
     * Создание новой записи
     * @return string
     */
    public function createAction()
    {
        $class = 'ApiV3\OrmModules\\' . Mapping::MAP[$this->config->apiName]['class'];
        $base = new $class($this->config, Mapping::MAP[$this->config->apiName]);
        return $base->createAction();
    }

    /**
     * Метод PUT
     * Обновление отдельной записи (по ее id)
     * @return string
     */
    public function updateAction()
    {
        $class = 'ApiV3\OrmModules\\' . Mapping::MAP[$this->config->apiName]['class'];
        $base = new $class($this->config, Mapping::MAP[$this->config->apiName]);
        return $base->updateAction();
    }

    /**
     * Метод DELETE
     * Удаление отдельной записи (по ее id)
     * @return string
     */
    public function deleteAction()
    {
        $class = 'ApiV3\OrmModules\\' . Mapping::MAP[$this->config->apiName]['class'];
        $base = new $class($this->config, Mapping::MAP[$this->config->apiName]);
        return $base->deleteAction();
    }
}