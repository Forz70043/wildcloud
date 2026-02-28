<?php

namespace WildCloud\Services;

use WildCloud\Core\Database;
use WildCloud\Models\User;

class AuthService
{
    /**
     * @param Database $db
     */
    public function __construct(private readonly Database $db) {}

    /**
     * @param string $username
     * @param string $password
     * @return User|null
     */
    public function login(string $username, string $password): ?User
    {
        $pdo = $this->db->connect();

        $stmt = $pdo->prepare("SELECT id, username, email, password FROM users WHERE username = :user");
        $stmt->execute(['user' => $username]);
        $data = $stmt->fetch();

        if ($data && password_verify($password, $data['password'])) {
            return new User(
                $data['id'],
                $data['username'],
                $data['email'],
                $data['password']
            );
        }

        return null;
    }
}