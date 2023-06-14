<?php

namespace controllers;

use helpers\ProjectHandler;
use helpers\TemplateRenderer;
use services\MainTemplateService;
use services\ProjectService;


class MainController extends BaseController
{
    protected MainTemplateService $mainTemplate;
    protected ProjectService $projects;

    public function __construct()
    {
        $this->mainTemplate = new MainTemplateService();
        $this->projects = new ProjectService();
    }

    public function index()
    {
        $title = 'Завдання та проекти | Дошка';
        $body = $this->mainTemplate->render();

        if (ProjectHandler::isExists($this->projects->getAll(), 'project_id') === false) {
            http_response_code(404);
            include('templates/404.php');
            exit();
        }

        return TemplateRenderer::execute('layout.php', ['title' => $title, 'body' => $body]);
    }
}