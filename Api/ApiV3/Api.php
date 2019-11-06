<?php


namespace ApiV3;

/**
 * Принцип работы API на примере несуществующего Book (поле class в Mapping)
 * подключается модуль ил поля 'module' в Mapping
 * Если есть класс Modules/Book, подключается он.
 * Если action в этом классе не описан, то идет обращение к action в Modules/Base
 * В action Modules/Base подключается класс OrmModules/Book, выполняется action
 * Если в OrmModules/Book action нет, то идет обращение к OrmModules/Base->action
 *
 * В Maping необходимо указывать заполнять эти поля
 * 'class' => 'Book',
 * 'module' => 'book', // модуль битрикса для включения
 * 'ormNamespace' => 'Bitrix\Book\BookTable', // таблица ORM
 * 'namespace' => 'Bitrix\Book\Book
 *
 *
 * Class Api
 * @package ApiV2
 */

abstract class Api
{
	/* @var ApiV3\Config */
	public $config;
	public $map;
	public $data;

    /**
     * Api constructor.
     */
    public function __construct(Config $config, $map) {
		header("Access-Control-Allow-Orgin: *");
		header("Access-Control-Allow-Methods: *");
		header("Content-Type: application/json");

        $this->config = $config;
        $this->map = $map;

        $user = new \CUser();
        $user->Authorize($this->config->user);
    }

    /**
     * @param $data
     */
    public function setError($data)
    {
        $this->data['success'] = 'error';
        $this->data['answer'] = $data;
    }

    /**
     * @param $data
     */
    public function setEmpty($data)
    {
        $this->data['success'] = 'empty';
        $this->data['answer'] = $data;
    }

    /**
     * @param $data
     */
    public function setOk($data)
    {
        $this->data['success'] = 'ok';
        $this->data['answer'] = $data;
    }

    /**
     * Проверка на корректность запроса
     * @return bool
     */
    public function isCorrectRequest()
    {
        if (!$this->config->user || !$this->config->action || !$this->config->apiName) {
            return false;
        }

        if (!method_exists($this, $this->config->action)) {
            return false;
        }

        return true;
    }

    /**
     * Отправим ошибку при обработке запроса, если есть
     * @return false|string
     */
    public function sendRequestError()
    {
        if (!$this->config->user) {
            $this->setError([
                'user' => $this->config->user ? $this->config->user : 'not found in request'
            ]);
            return $this->response(403);
        }

        if (!$this->config->action || !$this->config->apiName) {
            $this->setError([
                'action' => $this->config->action ? $this->config->action : 'not found in request',
                'apiName' => $this->config->apiName ? $this->config->apiName : 'not found in request',
            ]);
            return $this->response(400);
        }

        if (!method_exists($this, $this->config->action)) {
            $this->setError([
                'action' => $this->config->action
            ]);
            return $this->response(405);
        }

        if ($this->map['class'] == 'Error') {
            $this->setError([
                'apiName' => 'incorrect apiName in request. Try / before ? or check GET/POST request or spelling apiName'
            ]);
            return $this->response(500);
        }
    }

    /**
     * Если метод(действие) определен в дочернем классе API
     * @return mixed
     */
    public function run()
    {
        if (method_exists($this, $this->config->action)) {
            return $this->{$this->config->action}();
        } else {
            $this->setError('Invalid Method');
            $this->response(405);
        }
    }

    /**
     * Ответ клиенту
     * @param int $status
     * @return false|string
     */
    protected function response($status = 500) {
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        $response = new Response($this->data, $this->config, $this->map, $status . " " . $this->requestStatus($status));
        return json_encode($response->response(), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }

    /**
     * @param $code
     * @return mixed
     */
    public function requestStatus($code) {
        $status = [
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        ];
        return ($status[$code]) ? $status[$code] : $status[500];
    }

	abstract protected function indexAction();
    abstract protected function viewAction();
	abstract protected function viewCurrentAction();
    abstract protected function createAction();
    abstract protected function updateAction();
	abstract protected function deleteAction();
}