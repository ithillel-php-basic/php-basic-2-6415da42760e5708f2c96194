<?php
namespace services;

use helpers\GlobalArrayHandler;
use helpers\ProjectHandler;
use helpers\TemplateRenderer;

class MainSidebarTemplateService extends TemplateService
{
    protected UserService $userService;
    protected TaskService $taskService;

    public function __construct()
    {
        parent::__construct();
        $this->taskService = new TaskService();
        $this->userService = new UserService();
    }

    public function render(): string
    {
        $userPhoto = 'static/img/user2-160x160.jpg';

        return TemplateRenderer::execute('mainSidebar.php', [
            'userPhoto'     => $userPhoto,
            'user'          => $this->userService->logged(),
            'projects'      => $this->projectService->getAll(),
            'tasks'         => $this->taskService->getUserTasks(),
            'projectId'     => GlobalArrayHandler::getStringToInt('project_id'),
            'url'           => $_SERVER['REQUEST_URI'],
            'filter'        => $_GET['filter'] ?? null,
        ]);
    }
}
