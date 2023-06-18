<?php

namespace Rakit\Validation\Rules;

use databases\Sql;
use Rakit\Validation\MissingRequiredParameterException;
use Rakit\Validation\Rule;

class Exists extends Rule
{
    protected $message = ":attribute value does not exists.";

    protected $fillableParams = ['table', 'column', 'equal'];

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
        $equal = $this->parameter('equal');

        if (!isset($equal) && $equal !== $value) {
            return true;
        }

        // do query
        $sql = 'SELECT count(*) AS count FROM %s WHERE %s = :value';
        $data = $this->connection->query(sprintf($sql, $table, $column), [':value' => $value])->first();

        return intval($data['count']) === 1;
    }
}
