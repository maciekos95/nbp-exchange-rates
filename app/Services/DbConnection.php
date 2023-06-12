<?php

namespace App\Services;

use Exception;
use mysqli;

class DbConnection
{
    /**
     * @var mysqli The database connection object.
     */
    private mysqli $connection;

    /**
     * @var string The SQL query to be executed.
     */
    public $query;

    /**
     * @var array The parameters for the SQL query.
     */
    public $params;

    /**
     * DbConnection constructor.
     * @param string $query The SQL query to be executed.
     * @param array $params The parameters for the SQL query.
     */
    public function __construct(string $query = '', array $params = [])
    {
        $config = require 'config/database.php';

        $host = $config['host'];
        $database = $config['database'];
        $username = $config['username'];
        $password = $config['password'];

        try {
            $this->connection = new mysqli($host, $username, $password, $database);
        } catch (Exception $e) {
            exit(View::render(null, Lang::get('error_title'), [
                'errorMessages' => [Lang::get('database_connection_error') . ':<br>' . $e->getMessage()],
            ]));
        }

        $this->query = $query;
        $this->params = $params;
    }

    /**
     * Executes the SQL query.
     * @return array|bool The result set of the query or a boolean indicating success or failure.
     */
    public function execute(): array | bool
    {
        try {
            $statement = $this->connection->prepare($this->query);
        } catch (Exception $e) {
            exit(View::render(null, Lang::get('error_title'), [
                'errorMessages' => [Lang::get('statement_preparation_error') . ':<br>' . $e->getMessage()],
            ]));
        }

        if ($this->params) {
            $types = str_repeat('s', count($this->params));
            $statement->bind_param($types, ...$this->params);
        }

        try {
            $result = $statement->execute();
        } catch (Exception $e) {
            exit(View::render(null, Lang::get('error_title'), [
                'errorMessages' => [Lang::get('statement_execution_error') . ':<br>' . $e->getMessage()],
            ]));
        }

        $resultSet = $statement->get_result();

        if ($resultSet) {
            $data = [];

            while ($row = $resultSet->fetch_assoc()) {
                $data[] = $row;
            }

            return $data;
        }

        return $result;
    }
}