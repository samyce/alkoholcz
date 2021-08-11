<?php

namespace App\Model;

use Ublaboo\DataGrid\DataSource\ApiDataSource;

class DataSourceJson extends ApiDataSource
{
    const DATA_PER_PAGE = 10;

    private $dataLenght;

    public function __construct(string $url, array $queryParams = [])
    {
        parent::__construct($url, $queryParams);

        $this->limit = self::DATA_PER_PAGE;

        if(!empty($queryParams["page"]))
        {
            $this->offset = (int) $queryParams["page"] * $this->limit;
        }
    }

    protected function getResponse(array $params = [])
    {
        if(!$this->data)
        {
            $data = parent::getResponse($params);

            usort($data, function ($row1, $row2)
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
            });

            $this->dataLenght = is_array($data) ? count($data) : 0;
            $this->data = array_splice($data, $this->offset, $this->limit);
        }

        return $this->data;
    }

    public function getCount(): int
    {
        return $this->dataLenght;
    }

}