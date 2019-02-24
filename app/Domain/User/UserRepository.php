<?php

namespace App\Domain\User;

class UserRepository
{
    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * @param  UserFactory $userFactory
     */
    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    /**
     * @param  User $user
     * @return int
     */
    public function create(User $user): int
    {
        $user = \App\User::create([
            'email' => $user->getEmail(),
            'password' => bcrypt($user->getPassword()),
            'name' => $user->getName()
        ]);

        return $user->id;
    }
}