<?php

abstract class Controller
{
    protected $registry;

    public function __construct($registry)
    {
        $this->registry = $registry;
        $protocol = $_SERVER['HTTPS'] ? 'https://' : 'http://';

        if (!substr_count($_SERVER['SCRIPT_FILENAME'], 'admin') && !$this->customer->isLogged() && $this->url->link('account/login') != $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) {
            $this->response->redirect($this->url->link('account/login'));
        }
    }

    public function __get($key)
    {
        return $this->registry->get($key);
    }

    public function __set($key, $value)
    {
        $this->registry->set($key, $value);
    }
}