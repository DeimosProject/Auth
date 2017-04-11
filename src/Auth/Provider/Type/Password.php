<?php

namespace Deimos\Auth\Provider\Type;

use Deimos\Auth\Provider\Type;
use Deimos\ORM\Entity;

class Password extends Type
{

    /**
     * @var array
     */
    protected $options;

    /**
     * @return array
     */
    protected function options()
    {
        if (!$this->options)
        {
            $this->options = [
                'cost' => $this->slice->getData('options.cost', 12),
            ];
        }

        return $this->options;
    }

    /**
     * @param string $hash
     *
     * @return string
     */
    public function rehash($hash)
    {
        return password_needs_rehash($hash, PASSWORD_BCRYPT, $this->options());
    }

    /**
     * @param string $password
     *
     * @return string
     */
    public function hash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, $this->options());
    }

    /**
     * @param string $password
     * @param string $hash
     *
     * @return bool
     */
    public function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return null|Entity
     */
    public function login($username, $password)
    {
        $model       = $this->slice->getRequired('model');
        $loginFields = $this->slice->getRequired('loginFields');
        $hashField   = $this->slice->getRequired('hashField');

        $userQuery = $this->provider->auth()->orm()->repository($model);

        foreach ($loginFields as $field)
        {
            $userQuery->whereOr($field, $username);
        }

        $user = $userQuery->findOne();

        if ($user && $this->verify($password, $user->get($hashField)))
        {
            $this->provider->setUser($user);
        }

        return $user;
    }

}