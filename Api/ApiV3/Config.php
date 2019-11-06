<?php


namespace ApiV3;


class Config
{
    protected $apiPath;

    protected $method = ''; //GET|POST|PUT|DELETE
    public $apiName = ''; //users
    public $requestUri = [];
    public $requestParams = [];
    public $action = ''; //Название метод для выполнения
    public $user;



    /**
     * Api constructor.
     * дописать получение method и ссылку и параметры из реквеста
     */
    public function __construct($apiPath, $user = false)
    {
        $this->apiPath = $apiPath;
        //Массив GET параметров разделенных слешем
        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $this->requestParams = $_REQUEST;

        //Определение метода запроса
        $this->apiName = $this->setApiName();
        $this->method = $this->setMethod();
        $this->action = $this->setAction();

        /**
         * Доработать после авторизации
         */
        if ($user) {
            $this->user = $user;
        }
        else {
            $this->user = $this->setUser();
        }

    }

    /**
     * если пользователь передается в хедере
     * todo: переписать в API битрикс
     * @return bool|mixed
     */
    protected function setUser()
    {
        $user = $_SERVER['HTTP_TOKEN'] ? $_SERVER['HTTP_TOKEN'] : false;

        return $user;
    }

    /**
     * Определяем сущность запроса (USER / BLOG ...)
     * @return bool|mixed
     */
	protected function setApiName()
    {
		if(array_shift($this->requestUri) !== $this->apiPath){
            return false;
        }

		return array_shift($this->requestUri);
	}

    /**
     * Определяем метод (GET / POST)
     * nginx не работает с (put /  delete), их определяем далее
     * @return bool|mixed
     */
	protected function setMethod()
    {
		$method = $_SERVER['REQUEST_METHOD'] ? $_SERVER['REQUEST_METHOD'] : false;

		return $method;
	}

    /**
     * Определяем конкретно вызываемую функцию
     *
     * Для получения put / delete приходится слушать параметр method в body
     *
     * @return bool|string
     */
	protected function setAction()
    {
        $method = $this->method;
        switch ($method) {
            case 'GET':

                /**
                 * адрес типа /user/me/
                 */
                if($this->requestUri[0]==="me"){
                    return 'viewCurrentAction';
                }

                /**
                 * адрес типа /user/
                 */
                if($this->requestParams || !$this->requestUri[0]){
                    return 'indexAction';
                } else { // адрес типа /user/15/
                    return 'viewAction';
                }
                break;
            case 'POST':
                if($this->requestParams['method'] == 'update'){
                    return 'updateAction';
                } else if($this->requestParams['method'] == 'delete') {
                    return 'deleteAction';
                }
                return 'createAction';
                break;
        }
        return false;
    }

}