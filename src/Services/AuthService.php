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

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function register(string $username, string $email, string $password): bool
    {
        $pdo = $this->db->connect();

        $check = $pdo->prepare("SELECT id FROM users WHERE username = :u OR email = :e");
        $check->execute(['u' => $username, 'e' => $email]);
        if ($check->fetch()) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:u, :e, :p)");

        return $stmt->execute([
            'u' => $username,
            'e' => $email,
            'p' => $hashedPassword
        ]);
    }
}