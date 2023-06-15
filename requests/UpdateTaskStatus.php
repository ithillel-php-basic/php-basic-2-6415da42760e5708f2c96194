<?php
namespace requests;

class UpdateTaskStatus extends Request
{
    private int $id;
    private string $status;

    public function __construct()
    {
        parent::__construct();
    }

    public function setData(int $id, string $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    public function inputs(): array
    {
        return [
            'id'        => $this->id,
            'status'    => $this->status,
        ];
    }

    public function rules(): array
    {
        return [
            'id' => 'integer|exists:tasks,id,'.$this->id,
            'status' => 'in:backlog,to-do,in-progress,done'
        ];
    }
}
