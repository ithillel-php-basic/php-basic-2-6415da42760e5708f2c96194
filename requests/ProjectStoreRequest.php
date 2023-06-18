<?php
namespace requests;

use services\ProjectService;

class ProjectStoreRequest extends Request
{
    private string $title;
    private ProjectService $projects;

    public function __construct()
    {
        parent::__construct();
        $this->projects = new ProjectService();
    }

    public function setData(string $title)
    {
        $this->title = $title;
    }

    public function inputs(): array
    {
        return [
            'title' => $this->title,
        ];
    }

    public function rules(): array
    {
        $project = $this->projects->countProjectsByTitle($this->title);

        return [
            'title' => [
                'required',
                function () use ($project) {
                    return $project === 0 ? true : 'Project already exists.';
                }
            ],
        ];
    }
}
