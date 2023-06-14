<?php

namespace controllers;

use helpers\TemplateRenderer;

class GuessController
{
    public function index(): string
    {
        $title  = 'Kanban Board';

        $body = TemplateRenderer::execute('guest.php');

        return TemplateRenderer::execute('layout.php', [
            'title' => $title,
            'body'  => $body
        ]);
    }
}
