<?php

namespace Deimos\Auth\Provider;

use Deimos\Slice\Slice;

abstract class Type implements TypeInterface
{

    /**
     * @var Provider
     */
    protected $provider;

    /**
     * @var Slice
     */
    protected $slice;

    /**
     * Type constructor.
     *
     * @param Provider $provider
     * @param Slice    $config
     */
    public function __construct(Provider $provider, Slice $config)
    {
        $this->provider = $provider;
        $this->slice    = $config;
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