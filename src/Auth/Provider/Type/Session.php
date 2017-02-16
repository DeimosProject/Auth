<?php

namespace Deimos\Auth\Provider\Type;

use Deimos\Auth\Provider\Type;

class Session extends Type
{

    /**
     * @var string
     */
    protected $sessionKey = 'DeimosUserId';

    /**
     * @return string
     */
    protected function getKey()
    {
        return $this->provider->name() . $this->sessionKey;
    }

    public function persist()
    {
        $user = $this->provider->user();

        if ($user)
        {
            $session = $this->provider->auth()->session();
            $session->set($this->getKey(), $user->id());
        }
    }

    /**
     * @throws \Deimos\Helper\Exceptions\ExceptionEmpty
     */
    public function execute()
    {
        $session = $this->provider->auth()->session();
        $userId  = $session->get($this->getKey());

        if (!$userId)
        {
            return;
        }

        $persist  = $this->config->getRequired('persist');
        $provider = $this->provider->provider($persist);

        $model = $provider->config->get('model');

        $orm = $this->provider->auth()->orm();

        $user = $orm->repository($model)
            ->where($orm->mapPK($model), $userId)
            ->findOne();

        if ($user)
        {
            $this->provider->setUser($user);
        }

        return $user;
    }

    public function forget()
    {
        $session = $this->provider->auth()->session();
        $session->remove($this->getKey());

        parent::forget();
    }

}