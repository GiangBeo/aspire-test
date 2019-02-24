<?php

namespace App\Domain\User;

class UserFactory
{
    /**
     * @param  string $email
     * @param  string $password
     * @param  string $name
     * @param  int | null $id
     * @return User
     */
    public function make(
        $email,
        $password,
        $name,
        $id = null
    ): User
    {
        return new User($email, $password, $name, $id);
    }

    /**
     * @param  string $email
     * @param  string $password
     * @param  string $name
     * @return User
     */
    public function init(
        $email,
        $password,
        $name
    ): User
    {
        return $this->make($email, $password, $name);
    }

    /**
     * @param \App\User $eloquent
     * @return User
     */
    public function makeByEloquent(\App\User $eloquent): User
    {
        $id = $eloquent->id;
        $email = $eloquent->email;
        $password = $eloquent->password;
        $name = $eloquent->name;

        return $this->make($email, $password, $name, $id);
    }
}