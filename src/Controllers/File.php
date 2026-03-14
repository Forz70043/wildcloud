<?php

namespace WildCloud\Controllers;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use WildCloud\Core\View;
use WildCloud\Services\FileService;
class File
{
    private View $view;
    private FileService $fileService;

    /**
     * @param View $view
     * @param FileService $fileService
     */
    public function __construct(View $view, FileService $fileService) {
        $this->view = $view;
        $this->fileService = $fileService;
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(): string {
        // 1. Controllo sicurezza (spostabile in un Middleware in futuro)
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        // 2. Recupero dati dal Service
        $files = $this->fileService->getUserFiles($_SESSION['user_id']);

        // 3. Ritorno il render tramite la classe View
        return $this->view->render('dashboard.twig', [
            'files' => $files,
            'username' => $_SESSION['username']
        ]);
    }

    public function upload() {
        // Logica per gestire il $_FILES...
    }
}