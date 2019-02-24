<?php

namespace App\Domain\User;

class User
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int | null
     */
    private $id;

    /**
     * @param  string $email
     * @param  string $password
     * @param  string $name
     * @param  int | null $id
     */
    public function __construct(
        $email,
        $password,
        $name,
        $id = null
    )
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->id = $id;
    }

    /**
     * @return   int | null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return  string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return  string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return  string
     */
    public function getName(): string
    {
        return $this->name;
    }
}