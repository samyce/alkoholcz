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
     * @var \App\Facade\DataImporter @inject
     */
    public $dataImporter;

    /**
     * @var \App\Facade\DataSourceJson @inject
     */
    public $dataSourceJson;

    public function createComponentGrid():  DataGrid
    {
        $grid = new DataGrid();

        $grid->setDataSource($this->dataSourceJson);

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
        try
        {
            if($this->dataImporter->importData($ids))
            {
                $this->flashMessage("Import OK");
            }
            else
            {
                $this->flashMessage("Import failed. Contact support.");
            }
        }
        catch (\Exception $e)
        {
            $this->flashMessage("Import failed. Contact support.");
            $this->flashMessage($e->getMessage());
        }
    }

}
