<?php


namespace ApiV3;


use Setting\Options;
use Bitrix\Main\Loader;

class Response
{
    protected $data;
    protected $config;
    protected $map;
    protected $status;

    public function __construct($data, $config, $map, $status)
    {
        $this->data = $data;
        $this->config = $config;
        $this->map = $map;
        $this->status = $status;
    }

    public function response() {
        $this->log();

        return $this->data['answer'];
    }

    protected function log()
    {
        Loader::includeModule('module.setting');

        if ($this->data['success'] == 'error' && Options::apiErrorLog() == 'Y') {
            Logger::logError($this->data, $this->config, $this->map, $this->status);
        }

        if ($this->data['success'] == 'empty' && Options::apiEmptyLog() == 'Y') {
            Logger::logEmpty($this->data, $this->config, $this->map, $this->status);
        }

        if ($this->data['success'] == 'ok' && Options::apiLog() == 'Y') {
            Logger::logAll($this->data, $this->config, $this->map, $this->status);
        }
    }
}