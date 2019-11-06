<?php


namespace ApiV3;


use ApiV3\Logger;
use ApiV3\Responce;

class Error extends Api
{

    public function errorAction()
    {
        $data = [
            'error' => __FUNCTION__ . ': action deny'
        ];

        return $this->response($data, 405);
    }

    protected function indexAction()
    {
       return $this->errorAction();
    }

    protected function viewAction()
    {
        return $this->errorAction();
    }

    protected function viewCurrentAction()
    {
        return $this->errorAction();
    }

    protected function createAction()
    {
        return $this->errorAction();
    }

    protected function updateAction()
    {
        return $this->errorAction();
    }

    protected function deleteAction()
    {
        return $this->errorAction();
    }
}