<?php

namespace Deimos\Auth\Provider\Type;

use Deimos\Auth\Provider\Type;

class Cookie extends Type
{

    /**
     * @var string
     */
    protected $cookieKey = 'DeimosSeries';

    /**
     * @return string
     */
    protected function getKey()
    {
        return $this->provider->name() . $this->cookieKey;
    }

    public function persist()
    {
        $user = $this->provider->user();

        if ($user)
        {
            $series  = $this->provider->auth()->helper()->str()->random();
            $expires = $this->config->get('tokens.expires', 3600 * 24 * 14);

            $orm = $this->provider->auth()->orm();

            $model = $this->config->getRequired('tokens.model');

            $token = $orm->create($model);
            $save  = $token->save([
                'userId'  => $user->id(),
                'series'  => $series,
                'expires' => time() + $expires
            ]);

            if ($save)
            {
                $cookie = $this->provider->auth()->cookie();

                $cookie->set($this->getKey(), $series, [
                    \Deimos\Cookie\Cookie::OPTION_LIFETIME => $expires
                ]);
            }
        }

    }

    /**
     * @throws \Deimos\Helper\Exceptions\ExceptionEmpty
     */
    public function execute()
    {
        $cookie = $this->provider->auth()->cookie();
        $series = $cookie->get($this->getKey());

        if (!$series)
        {
            return null;
        }

        $model = $this->config->getRequired('tokens.model');

        $orm = $this->provider->auth()->orm();

        $token = $orm->repository($model)
            ->where('series', $series)
            ->where('expires', '>=', time())
            ->findOne();

        if ($token)
        {
            $userId = $token->userId;

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

        return null;
    }

    public function forget()
    {
        $cookie = $this->provider->auth()->cookie();
        $series = $cookie->get($this->getKey());
        $cookie->remove($this->getKey());

        $model = $this->config->getRequired('tokens.model');

        $user = $this->provider->auth()->orm()->repository($model)
            ->where('series', $series)
            ->where('expires', '>=', time())
            ->findOne();

        if ($user)
        {
            $user->delete();
        }

        parent::forget();
    }

}