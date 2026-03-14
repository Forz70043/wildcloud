<?php

namespace WildCloud\Models;

readonly class User
{
    /**
     * @param int $id
     * @param string $username
     * @param string $email
     * @param string $passwordHash
     */
    public function __construct(
        public int     $id,
        public string  $username,
        public string  $email,
        private string $passwordHash
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