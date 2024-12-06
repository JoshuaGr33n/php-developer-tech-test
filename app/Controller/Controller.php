<?php

namespace App\Controller;

abstract class Controller
{
    /**
     * Renders a twig template with the params provided.
     *
     * @param string $view
     * @param array $params
     */
    protected function render(string $view, array $params = [])
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/views');
        $twig = new \Twig\Environment($loader);

        echo $twig->render(sprintf('layouts/%s', $view), $params);
    }
}