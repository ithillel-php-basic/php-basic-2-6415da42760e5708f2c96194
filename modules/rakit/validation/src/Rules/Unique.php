<?php

namespace Rakit\Validation\Rules;

use databases\Sql;
use Rakit\Validation\MissingRequiredParameterException;
use Rakit\Validation\Rule;

class Unique extends Rule
{
    protected $message = ":attribute :value has been used";

    protected $fillableParams = ['table', 'column'];

    protected Sql $connection;

    public function __construct()
    {
        $this->connection = new Sql();
    }

    /**
     * @throws MissingRequiredParameterException
     */
    public function check($value): bool
    {
        // make sure required parameters exists
        $this->requireParameters(['table', 'column']);

        // getting parameters
        $column = $this->parameter('column');
        $table = $this->parameter('table');

        // do query
        $sql = "SELECT * FROM {$table} WHERE {$column} = :value";
        $data = $this->connection->query($sql, [':value' => $value]);
        $count = $data->fetchColumn();

        // true for valid, false for invalid
        return !($count > 0);
    }
}