<?php

namespace WildCloud\Models;

class User
{
    /**
     * @param int $id
     * @param string $username
     * @param string $email
     * @param string $passwordHash
     */
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $email,
        private readonly string $passwordHash
    ) {}

    /**
     * @param string $password
     * @return bool
     */
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->passwordHash);
    }
}