<?php

namespace Deimos\Auth\Provider;

use Deimos\Config\ConfigObject;

abstract class Type implements TypeInterface
{

    /**
     * @var Provider
     */
    protected $provider;

    /**
     * @var \Deimos\Config\ConfigObject
     */
    protected $config;

    /**
     * Type constructor.
     *
     * @param Provider     $provider
     * @param ConfigObject $config
     */
    public function __construct(Provider $provider, ConfigObject $config)
    {
        $this->provider = $provider;
        $this->config   = $config;
    }

    public function forget()
    {
        $this->provider->setUser(null);
    }

    /**
     * @return null
     */
    public function execute()
    {
        return null;
    }

}