<?php

namespace requests;

use Carbon\Carbon;
use Rakit\Validation\Validation;

class StoreTaskRequest extends Request
{
    private string $yesterday;
    private string $title;
    private string $description;
    private string $project;
    private string $deadline;

    public function __construct()
    {
        parent::__construct();
        $this->yesterday = Carbon::now()->subDays('1')->format('Y-m-d');
    }

    public function setData(string $title, string $description, string $project, string $deadline)
    {
        $this->title = $title;
        $this->description = $description;
        $this->project = $project;
        $this->deadline = $deadline;
    }

    public function inputs(): array
    {
        return [
            'title'         => $this->title,
            'description'   => $this->description,
            'project'       => $this->project,
            'deadline'      => $this->deadline,
        ];
    }

    public function rules(): array
    {
        return [
            'title'         => 'required',
            'description'   => 'nullable',
            'project'       => 'required|exists:projects,id,' . $this->project,
            'deadline'      => 'nullable|date:Y-m-d|after:' . $this->yesterday,
            'file'          => 'uploaded_file:0,2M'
        ];
    }
}
