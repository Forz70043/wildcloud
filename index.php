<?php
require_once __DIR__ . '/vendor/autoload.php';

use WildCloud\Core\Database;
use WildCloud\Services\AuthService;
use WildCloud\Core\View;
use WildCloud\Controllers\User;

session_start([
    'cookie_httponly' => true,
    'cookie_secure'   => false,
    'use_strict_mode' => true,
]);

// --- I18n Setup ---
$lang = $_SESSION['lang'] ?? 'it_IT';
$locale = $lang . ".UTF-8";

putenv("LC_ALL=$locale");
putenv("LANGUAGE=$locale");
setlocale(LC_ALL, $locale);

$domain = getenv('I18N_FILE') ?: 'messages';
bindtextdomain($domain, __DIR__ . '/translations');
bind_textdomain_codeset($domain, 'UTF-8');
textdomain($domain);

// --- Dependencies ---
$db = new Database();
$auth = new AuthService($db);

$viewsPath = __DIR__ . (getenv('VIEWS_FOLDER') ?: '/views');
$view = new View($viewsPath, true);

$userController = new User($auth, $view);
$page = $_GET['page'] ?? 'home';

$response = "";

// --- Router ---
switch ($page) {
    case 'login':
        $response = $userController->login();
        break;

    case 'register':
        $response = $userController->register();
        break;

    case 'logout':
        $userController->logout();
        break;

    case 'dashboard':
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $response = $view->render('dashboard.twig', [
            'username' => $_SESSION['username'],
            'files' => $userFiles ?? []
        ]);
        break;

    default:
        $response = $view->render('home.twig');
        break;
}

echo $response;