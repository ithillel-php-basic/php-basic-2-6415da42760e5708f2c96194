<?php

namespace Rakit\Validation\Rules;

use databases\Sql;
use Rakit\Validation\MissingRequiredParameterException;
use Rakit\Validation\Rule;

class Unique extends Rule
{
    protected $message = ":attribute :value has been used";

    protected $fillableParams = ['table', 'column', 'except'];

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
        $except = $this->parameter('except');

        if ($except && $except == $value) {
            return true;
        }

        // do query
        $sql = 'SELECT count(*) AS count FROM %s WHERE %s = :value';
        $data = $this->connection->query(sprintf($sql, $table, $column), [':value' => $value])->first();

        // true for valid, false for invalid
        return intval($data['count']) === 0;
    }
}