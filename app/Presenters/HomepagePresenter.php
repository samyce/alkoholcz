<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Ublaboo\DataGrid\DataGrid;
use App\Model\DataSourceJson;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    /**
     * @var Nette\DI\Container @inject
     */
    public $container;

    /**
     * @var \App\Model\DataImporter @inject
     */
    public $dataImporter;

    public function createComponentGrid():  DataGrid
    {
        $page = $this->getRequest()->getParameter("grid-page");

        $grid = new DataGrid();

        $apiDataSource = new DataSourceJson("https://www.3it.cz/test/data/json", ["page" => $page]);

        $grid->setDataSource($apiDataSource);

        $grid->addGroupButtonAction('Import')->onClick[] = [$this, 'importFromGrid'];
        $grid->setItemsPerPageList([20, 50, 100], false);

        $grid->addColumnText('id', 'ID');
        $grid->addColumnText('jmeno', 'Jméno');
        $grid->addColumnText('prijmeni', 'Přijmení');
        $grid->addColumnText('date', 'Datum');

        return $grid;
    }

    public function importFromGrid($ids)
    {
        $data = []; // TODO

        try {
            $this->dataImporter->importData($data);
        }
        catch (\Exception $e)
        {
            $this->flashMessage($e->getMessage());
        }
    }

}
