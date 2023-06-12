<?php

require_once 'app/Services/DbConnection.php';

use App\Services\DbConnection;
use App\Services\Lang;

$dbConnection = new DbConnection;
$migrationFiles = glob('migrations/*.php');

foreach ($migrationFiles as $file) {
    try {
        require_once $file;
        $migrationClass = basename($file, '.php');
        $migrationClassInstance = new $migrationName();
        $dbConnection->query = $migrationClassInstance->up();
        $dbConnection->execute($query);

        echo Lang::get('migration') . $migrationName . Lang::get('completed_successfully') . PHP_EOL;
    } catch (Exception $e) {
        echo Lang::get('error_during_migration') . $migrationName . ': ' . $e->getMessage() . PHP_EOL;
    }
}
