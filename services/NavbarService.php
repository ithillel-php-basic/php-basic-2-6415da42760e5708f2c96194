<?php
namespace services;

use helpers\GlobalArrayHandler;
use helpers\TemplateRenderer;

class NavbarService extends TemplateService
{
    public function render(): string
    {
        return TemplateRenderer::execute('navbar.php', [
            'projectId'     => GlobalArrayHandler::getStringToInt('project_id'),
            'url'           => $_SERVER['REQUEST_URI'],
            'pageName'      => $_SERVER['SCRIPT_NAME'],
            'queryStr'      => GlobalArrayHandler::getQueryString(),
        ]);
    }
}