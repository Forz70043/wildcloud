<?php
namespace WildCloud\Controllers;

use JetBrains\PhpStorm\NoReturn;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use WildCloud\Core\View;
use WildCloud\Services\AuthService;

class User {

    /**
     * @param AuthService $auth
     * @param View $twig
     */
    public function __construct(
        private readonly AuthService $auth,
        private readonly View $twig
    ) {}

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function login(): string
    {
        $error = null;
        $message = isset($_GET['registered']) ? _("Registration successful! Please login.") : null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->auth->login($_POST['username'] ?? '', $_POST['password'] ?? '');
            if ($user) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                header('Location: index.php?page=dashboard');
                exit;
            }
            $error = _("Wrong credentials!");
        }

        return $this->twig->render('login.twig', [
            'error' => $error,
            'message' => $message
        ]);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function register(): string
    {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->auth->register($_POST['username'] ?? '', $_POST['email'] ?? '', $_POST['password'] ?? '')) {
                header('Location: index.php?page=login&registered=1');
                exit;
            } else {
                $error = _("Error: Username or Email already exist.");
            }
        }
        return $this->twig->render('register.twig', ['error' => $error]);
    }

    /**
     * @return void
     */
    #[NoReturn]
    public function logout(): void
    {
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}