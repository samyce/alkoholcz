<?php

namespace App\Facade;

use Ublaboo\DataGrid\DataSource\ApiDataSource;

/**
 * Class DataSourceJson
 * @package App\Facade
 */
class DataSourceJson extends ApiDataSource
{

    private $dataLenght;

    public function __construct(string $url, array $queryParams = [])
    {
        parent::__construct($url, $queryParams);
    }

    protected function getResponse(array $params = [])
    {
        if(!$this->data) {
            $data = parent::getResponse($params);

            usort($data, [$this, "sortDataDefault"]);

            $this->dataLenght = is_array($data) ? count($data) : 0;

            $this->data = is_array($data) ? $data : [];
            if($this->limit !== 0)
            {
                $this->data = array_splice($this->data, $this->offset, $this->limit);
            }
        }

        return $this->data;
    }

    public function getCount(): int
    {
        return $this->dataLenght;
    }

    /**
     * @param \stdClass $row1
     * @param \stdClass $row2
     * @return int
     */
    private function sortDataDefault(\stdClass $row1, \stdClass $row2)
    {
        $date1 = \DateTime::createFromFormat("Y-m-d", $row1->date);
        $date2 = \DateTime::createFromFormat("Y-m-d", $row2->date);

        if ($date1 < $date2)
        {
            return -1;
        }
        elseif ($date1 > $date2)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

}