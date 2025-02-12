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
class ListMember extends ListController
{

    private const VIEW_MEMBER = 'ListMember';
    private const VIEW_EVENT = 'ListVisitor';

    /**
     * Returns basic page attributes
     *
     * @return array
     */
    public function getPageData(): array
    {
        $pagedata = parent::getPageData();
        $pagedata['title'] = 'members';
        $pagedata['icon'] = 'fa-solid fa-user-group';
        $pagedata['menu'] = 'test';
        $pagedata['ordernum'] = 0;

        return $pagedata;
    }

    /**
     * Load views
     */
    protected function createViews()
    {
        $this->createViewMembers();
        $this->createViewVisitors();
       
    }

    /**
     * Add and configure absence concept view
     *
     * @param string $viewName
     */
    private function createViewMembers($viewName = self::VIEW_MEMBER)
    {
        $this->addView($viewName, 'Member', 'members', 'fa-solid fa-user-groupy');
        $this->addSearchFields($viewName, ['name', 'id', 'surname']);

        $this->addOrderBy($viewName, ['id'], 'code');
        $this->addOrderBy($viewName, ['name', 'surname'], 'name', 1);   
            
        
    }

    /**
     * Add and configure absence concept view
     *
     * @param string $viewName
     */
    private function createViewVisitors($viewName = self::VIEW_EVENT)
    {
        $this->addView($viewName, 'Visitor', 'visitors', 'fa-solid fa-masks-theater');
        $this->addSearchFields($viewName, ['name', 'id', 'phone']);

        $this->addOrderBy($viewName, ['id'], 'code', 2);
        $this->addOrderBy($viewName, ['name'], 'name', 1);           
        
    }

}
