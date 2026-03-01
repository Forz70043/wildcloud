<?php
require_once __DIR__ . '/vendor/autoload.php';

use WildCloud\Core\Database;
use WildCloud\Services\AuthService;
use WildCloud\Core\View;

session_start([
    'cookie_httponly' => true,
    'cookie_secure'   => false,
    'use_strict_mode' => true,
]);

$lang = $_SESSION['lang'] ?? 'it_IT';
$locale = $lang . ".UTF-8";

putenv("LC_ALL=$locale");
putenv("LANGUAGE=$locale");
setlocale(LC_ALL, $locale);

$domain = getenv('I18N_FILE') ?: 'messages';
bindtextdomain($domain, __DIR__ . '/translations');
bind_textdomain_codeset($domain, 'UTF-8');
textdomain($domain);

$db = new Database();
$auth = new AuthService($db);
$view = new View(__DIR__ . getenv('VIEWS_FOLDER') ?: '/views', true);
$user = new \WildCloud\Controllers\User($auth, $view);
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'login':
        $response = $user->login();
        break;

    case 'register':
        $response = $user->register();
        break;

    case 'logout':
        $user->logout();
        break;

    case 'dashboard':
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        echo $view->render('dashboard.twig', [
            'username' => $_SESSION['username']
        ]);
        break;

    default:
        echo $view->render('home.twig');
        break;
}
