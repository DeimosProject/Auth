<?php

namespace Deimos\Auth;

use Deimos\Builder\Builder;
use Deimos\Config\ConfigObject;
use Deimos\Cookie\Cookie;
use Deimos\Helper\Helper;
use Deimos\ORM\ORM;
use Deimos\Session\Session;

class Auth
{

    /**
     * @var ORM
     */
    protected $orm;

    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @var string
     */
    protected $provider = Provider\Provider::class;

    /**
     * @var Cookie
     */
    protected $cookie;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Provider\Provider[]
     */
    protected $domains = [];

    /**
     * @var ConfigObject
     */
    protected $config;

    /**
     * Auth constructor.
     *
     * @param $orm    ORM
     * @param $config ConfigObject
     */
    public function __construct(ORM $orm, ConfigObject $config)
    {
        $this->orm    = $orm;
        $this->config = $config;
    }

    /**
     * @param string $name
     *
     * @return Provider\Provider
     */
    public function domain($name = 'default')
    {
        if (!isset($this->domains[$name]))
        {
            $slice = $this->config->slice($name);
            $class = $this->provider;

            $this->domains[$name] = new $class($this, $slice, $name);
        }

        return $this->domains[$name];
    }

    /**
     * @return ORM
     */
    public function orm()
    {
        return $this->orm;
    }

    /**
     * @return Builder
     */
    protected function builder()
    {
        if (!$this->builder)
        {
            $this->builder = new Builder();
        }

        return $this->builder;
    }

    /**
     * @return Helper
     */
    public function helper()
    {
        if (!$this->helper)
        {
            $this->helper = new Helper($this->builder());
        }

        return $this->helper;
    }

    /**
     * @param Cookie $cookie
     */
    public function setCookie(Cookie $cookie)
    {
        $this->cookie = $cookie;
    }

    /**
     * @return Cookie
     */
    public function cookie()
    {
        if (!$this->cookie)
        {
            $this->cookie = new Cookie($this->builder());
        }

        return $this->cookie;
    }

    /**
     * @param Session $session
     */
    public function setSession(Session $session)
    {
        if (!$this->cookie)
        {
            $this->cookie = new Cookie($this->builder());
        }

        $this->session = $session;
    }

    /**
     * @return Session
     */
    public function session()
    {
        if (!$this->session)
        {
            $this->session = new Session($this->builder());
        }

        return $this->session;
    }

}