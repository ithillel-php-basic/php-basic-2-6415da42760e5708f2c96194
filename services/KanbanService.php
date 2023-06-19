<?php

namespace services;

use helpers\GlobalArrayHandler;
use helpers\ProjectHandler;
use helpers\TemplateRenderer;

class KanbanService extends TemplateService
{
    protected ProjectHandler $projectHandler;
    protected TaskService $taskService;

    public function __construct()
    {
        parent::__construct();
        $this->taskService = new TaskService();
        $this->projectHandler = new ProjectHandler();
    }

    public function render(): string
    {
        return TemplateRenderer::execute('kanban.php', [
            'tasks'         => $this->taskService->getUserTasks(),
            'projects'      => $this->projectService->getAll(),
            'pageTitle'     => $this->projectHandler->showTitle($this->projectService->getAll(), 'project_id'),
            'projectId'     => GlobalArrayHandler::getStringToInt('project_id'),
            'url'           => $_SERVER['REQUEST_URI'],
            'filter'        => $_GET['filter'] ?? null,
        ]);
    }
}
