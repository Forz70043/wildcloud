<?php

namespace WildCloud\Services;

use WildCloud\Core\Database;
use PDO;

class FileService
{
    /**
     * @param Database $db
     */
    public function __construct(
        private readonly Database $db
    ) {}

    /**
     * Recupera la lista dei file di un utente specifico
     */
    public function getUserFiles(int $userId): array {
        $pdo = $this->db->connect();
        $sql = "SELECT id, filename, filesize, mime_type, created_at 
                FROM cloud_files 
                WHERE user_id = :uid 
                ORDER BY created_at DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['uid' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Esempio di metodo per registrare un nuovo upload nel DB
     */
    public function registerFileUpload(int $userId, string $name, int $size, string $type): bool {
        $pdo = $this->db->connect();
        $sql = "INSERT INTO cloud_files (user_id, filename, filesize, mime_type) 
                VALUES (:uid, :name, :size, :type)";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'uid'  => $userId,
            'name' => $name,
            'size' => $size,
            'type' => $type
        ]);
    }
}