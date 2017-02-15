<?php

namespace Deimos\Auth\Provider;

interface TypeInterface
{

    /**
     * @return mixed
     */
    public function execute();

    public function forget();

}