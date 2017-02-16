<?php

namespace Deimos\Auth\Provider;

use Deimos\Auth\Auth;
use Deimos\Config\ConfigObject;
use Deimos\Cookie\Cookie;
use Deimos\ORM\Entity;
use Deimos\Session\Session;

class Provider
{

    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var Entity
     */
    protected $user;

    /**
     * @var ConfigObject
     */
    protected $config;

    /**
     * @var Cookie
     */
    protected $cookie;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $mapClasses = [
        'cookie'   => Type\Cookie::class,
        'session'  => Type\Session::class,
        'password' => Type\Password::class,
    ];

    /**
     * Provider constructor.
     *
     * @param Auth         $auth
     * @param ConfigObject $config
     * @param string       $name
     */
    public function __construct(Auth $auth, ConfigObject $config, $name)
    {
        $this->auth   = $auth;
        $this->config = $config;
        $this->name   = $name;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return Auth
     */
    public function auth()
    {
        return $this->auth;
    }

    /**
     * @param string $name
     *
     * @return Type
     */
    public function provider($name)
    {
        $slice = $this->config->slice($name);

        $type  = $slice->getRequired('type');
        $class = $this->mapClasses[$type];

        return new $class($this, $slice);
    }

    /**
     * @param Entity $entity
     *
     * @return static
     */
    public function setUser($entity)
    {
        $this->user = $entity;

        return $this;
    }

    /**
     * @return Entity|null
     */
    public function user()
    {
        if (!$this->user)
        {
            foreach ($this->config as $name => $class)
            {
                $this->provider($name)->execute();
            }
        }

        return $this->user;
    }

    public function forgetUser()
    {
        foreach ($this->config as $name => $class)
        {
            $this->provider($name)->forget();
        }
    }

}