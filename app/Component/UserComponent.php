<?php

namespace App\Component;

use App\Domain\User\UserFactory;
use App\Domain\User\UserRepository;

class UserComponent
{
    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param UserFactory $userFactory
     * @param UserRepository $userRepository
     */
    public function __construct(UserFactory $userFactory, UserRepository $userRepository)
    {
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $username
     * @param string $password
     * @return int
     */
    public function createUser(string $username, string $password, string $name) : int
    {
        $user = $this->userFactory->init($username, $password, $name);
        return $this->userRepository->create($user);
    }
}