<?php

namespace WildCloud\Core;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class View
{
    private Environment $twig;

    /**
     * @param string $templatePath
     * @param bool $debug
     */
    public function __construct(
        string $templatePath,
        bool $debug = false
    ) {
        $loader = new FilesystemLoader($templatePath);

        $this->twig = new Environment($loader, [
            'cache' => getenv('TWIG_CACHE'),
            'debug' => getenv('TWIG_DEBUG'),
            'strict_variables' => true,
        ]);

        if ($debug) {
            $this->twig->addExtension(new DebugExtension());
        }

        $this->registerGlobals();
        $this->registerFunctions();
    }

    /**
     * @return void
     */
    private function registerGlobals(): void
    {
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addGlobal('current_lang', $_SESSION['lang'] ?? 'it_IT');
    }

    /**
     * @return void
     */
    private function registerFunctions(): void
    {
        // translate: {{ __("Key") }}
        $this->twig->addFunction(new TwigFunction('__', function ($string) {
            return _($string);
        }));

        $this->twig->addFunction(new TwigFunction('format_bytes', function ($bytes) {
            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);
            $bytes /= pow(1024, $pow);
            return round($bytes, 2) . ' ' . $units[$pow];
        }));
    }

    /**
     * @param string $template
     * @param array $data
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $template, array $data = []): string {
        return $this->twig->render($template, $data);
    }
}