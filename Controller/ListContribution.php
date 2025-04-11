<?php
/**
 * This file is part of PrevisionPagos plugin for FacturaScripts.
 * FacturaScripts Copyright (C) 2015-2022 Carlos Garcia Gomez <carlos@facturascripts.com>
 * PrevisionPagos Copyright (C) 2022-2024 Jose Antonio Cuello Principal <yopli2000@gmail.com>
 *
 * This program and its files are under the terms of the license specified in the LICENSE file.
 */
namespace FacturaScripts\Plugins\PruebaPlugin\Controller;

use FacturaScripts\Core\Lib\ExtendedController\ListController;
use FacturaScripts\Core\Tools;
use FacturaScripts\Plugins\PrevisionPagos\Lib\PrevisionPagos\ForecastSupplierReport;

/**
 * Controller to list data of Forecast Supplier model.
 *
 * @author Jose Antonio Cuello Principal <yopli2000@gmail.com>
 */
class ListContribution extends ListController
{

    private const VIEW_CONTRIBUTION = 'ListContribution';

    /**
     * Returns basic page attributes
     *
     * @return array
     */
    public function getPageData(): array
    {
        $pagedata = parent::getPageData();
        $pagedata['title'] = 'contribution';
        $pagedata['icon'] = 'fa-solid fa-sack-dollar';
        $pagedata['menu'] = 'test';
        $pagedata['ordernum'] = 0;

        return $pagedata;
    }

    /**
     * Load views
     */
    protected function createViews()
    {
        $this->createViewContributions();
       
    }

    /**
     * Add and configure absence concept view
     *
     * @param string $viewName
     */
    private function createViewContributions($viewName = self::VIEW_CONTRIBUTION)
    {
        $this->addView($viewName, 'Join\Contribution', 'contribution', 'fa-solid fa-masks-theater');
        $this->addSearchFields($viewName, ['name', 'id']);

        $this->addOrderBy($viewName, ['id'], 'code');
         
        
        
    }

}
