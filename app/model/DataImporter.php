<?php

namespace App\Model;


use Nette\Database\Connection;

class DataImporter
{
    use \Nette\SmartObject;

    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function importData(array $data): bool
    {
        $this->connection->query('INSERT INTO zaznamy', [
            $data
        ]);
    }

}