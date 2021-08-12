<?php

namespace App\Facade;


use App\Model\RecordRepository;
use Nette\SmartObject;

/**
 * Class DataImporter
 * @package App\Facade
 */
class DataImporter
{
    use SmartObject;

    /**
     * @var RecordRepository
     */
    private $userRepository;

    /**
     * @var DataSourceJson
     */
    private $dataSourceJson;

    public function __construct(
        RecordRepository $userRepository,
        DataSourceJson $dataSourceJson)
    {
        $this->userRepository = $userRepository;
        $this->dataSourceJson = $dataSourceJson;
    }

    /**
     * @param array $ids
     * @return bool
     */
    public function importData(array $ids): bool
    {
        $this->dataSourceJson->limit(0, 0);

        $data = $this->dataSourceJson->getData();
        $dataToImport = [];

        foreach ($data as $row)
        {
            if(!in_array($row->id, $ids))
            {
                continue;
            }

            $dataToImport[] = [
                    "id" => $row->id,
                    "jmeno" => $row->jmeno,
                    "prijmeni" => $row->prijmeni,
                    "datum" => $row->date,
                ];
        }

        return $this->userRepository->save($dataToImport);
    }

}