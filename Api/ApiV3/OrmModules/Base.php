<?php

namespace Sibur\Rest\ApiV3\OrmModules;

use Sibur\Rest\ApiV3\Api;
use Sibur\Rest\ApiV3\ApiConfig;

/**
 * Пример типовых запросов через ORM
 * Если внутри класса нет специфики, то будет обращаться к этому классу
 * Class Base
 * @package Sibur\Rest\ApiV3\OrmModules
 */

class Base extends Api
{
    /**
     * Метод GET
     * Вывод списка всех записей
     * $parameters = [
     *      "select" => array of fields in the SELECT part of the query, aliases are possible in the form of "alias"=>"field"
     *        "filter" => array of filters in the WHERE part of the query in the form of "(condition)field"=>"value"
     *        "group" => array of fields in the GROUP BY part of the query
     *        "order" => array of fields in the ORDER BY part of the query in the form of "field"=>"asc|desc"
     *        "limit" => integer indicating maximum number of rows in the selection (like LIMIT n in MySql)
     *        "offset" => integer indicating first row number in the selection (like LIMIT n, 100 in MySql)
     *        "runtime"
     *    ];
     *
     * Ex: \Bitrix\Im\MessageTable::getList($parameters);
     *
     *
     * @param null $parameters
     * @return string
     */
    public function indexAction()
    {
        $parameters = array(
            'select' => array('*'),
            'filter' => array(),
            'group' => array(),
            'order' => array(),
            'offset' => $this->config->requestParams['offset'] ? $this->config->requestParams['offset'] : 0,
            'limit' => $this->config->requestParams['limit'] ? $this->config->requestParams['limit'] : 50,
        );
        foreach ($this->config->requestParams as $param => $value) {

            if ($param == 'offset' || $param == 'limit') {
                $parameters[$param] = $value ? $value : ($param == 'limit' ? 50 : 0);
                continue;
            }

            $parameters['filter'][$param] = $value;

        }


        $queryResult = $this->map['ormNamespace']::getList($parameters);
        $results = [];
        foreach($queryResult as $result) {
            $results[] = $result;
        }
        return $this->response($results, 200);
    }

    /**
     * Метод GET
     * Просмотр текущей записи
     * @param null $id
     * @return string
     */
	
	public function viewCurrentAction()
    {    
        return $this->response('Data not found', 404);
	}
	
	
	
	/**
     * Метод GET
     * Просмотр отдельной записи (по id)
     * @param null $id
     * @return string
     */
    public function viewAction()
    {
        $id = array_shift($this->config->requestUri);

        if($id){
            return $this->response($this->map['ormNamespace']::getById($id)->fetch(), 200);
        }
        return $this->response('Data not found', 404);
    }

    /**
     * Метод POST
     * Создание новой записи
     * @param null $data
     * @return string
     */
    public function createAction()
    {

        // обработка запроса

        // создание
    }

    /**
     * Метод PUT
     * Обновление отдельной записи (по ее id)
     * @param null $parameters
     * @return string
     */
    public function updateAction()
    {

        // обработка запроса

        // обновление
    }

    /**
     * Метод DELETE
     * Удаление отдельной записи (по ее id)
     * @param null $id
     * @return string
     */
    public function deleteAction()
    {

        $id = array_shift($this->config->requestUri);

        if($id){
            return $this->response($this->map['namespace']::delete($id), 200);
        }
        return $this->response('Data not found', 404);
    }

}