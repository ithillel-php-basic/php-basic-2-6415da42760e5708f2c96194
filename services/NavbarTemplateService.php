<?php

namespace services;

use helpers\GlobalArrayHandler;
use helpers\TemplateRenderer;

class NavbarTemplateService extends TemplateService
{
    public function render(): string
    {
        return TemplateRenderer::execute('navbar.php', [
            'projectId'     => GlobalArrayHandler::getStringToInt('project_id'),
            'url'           => $_SERVER['REQUEST_URI'],
            'queryStr'      => GlobalArrayHandler::getQueryString(),
        ]);
    }
}
