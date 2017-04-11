<?php

namespace Deimos\Auth\Provider;

use Deimos\Auth\Auth;
use Deimos\Config\ConfigObject;
use Deimos\Cookie\Cookie;
use Deimos\ORM\Entity;
use Deimos\Session\Session;
use Deimos\Slice\Slice;

class Provider
{

    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var bool
     */
    protected $try;

    /**
     * @var Entity
     */
    protected $user;

    /**
     * @var Slice
     */
    protected $slice;

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
     * @param Auth   $auth
     * @param Slice  $slice
     * @param string $name
     */
    public function __construct(Auth $auth, Slice $slice, $name)
    {
        $this->auth  = $auth;
        $this->slice = $slice;
        $this->name  = $name;
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
        $slice = $this->slice->getSlice($name);

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
        if (!$this->try && !$this->user)
        {
            foreach ($this->slice as $name => $class)
            {
                if ($this->provider($name)->execute())
                {
                    break;
                }
            }

            $this->try = true;
        }

        return $this->user;
    }

    public function forgetUser()
    {
        foreach ($this->slice as $name => $class)
        {
            $this->provider($name)->forget();
        }
    }

}