<?php

namespace services;

abstract class TemplateService
{
    protected ProjectService $projectService;

    public function __construct()
    {
        $this->projectService = new ProjectService();
    }

    abstract public function render();
}
