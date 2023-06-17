<?php
namespace services;

use helpers\TemplateRenderer;

class MainTemplateService extends TemplateService
{
    protected KanbanService $kanbanTemplate;
    protected NavbarTemplateService $navbarTemplate;
    protected MainSidebarTemplateService $mainSidebarTemplate;

    public function __construct()
    {
        parent::__construct();
        $this->kanbanTemplate = new KanbanService();
        $this->navbarTemplate = new NavbarTemplateService();
        $this->mainSidebarTemplate = new MainSidebarTemplateService();
    }

    public function render(): string
    {
        return TemplateRenderer::execute('main.php', [
            'kanbanTemplate'        => $this->kanbanTemplate->render(),
            'mainSidebarTemplate'   => $this->mainSidebarTemplate->render(),
            'navbarTemplate'        => $this->navbarTemplate->render(),
        ]);
    }
}
