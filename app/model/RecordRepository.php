<?php


namespace App\Model;


use Nette\Database\Connection;

class RecordRepository
{
    use \Nette\SmartObject;

    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function save(array $data): bool
    {
        return $this->connection->query('INSERT INTO zaznamy', $data)->getRowCount() > 0;
    }
}