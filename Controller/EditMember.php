<?php
/**
 * This file is part of PrevisionPagos plugin for FacturaScripts.
 * FacturaScripts  Copyright (C) 2015-2022 Carlos Garcia Gomez <carlos@facturascripts.com>
 * PrevisionPagos  Copyright (C) 2022-2024 Jose Antonio Cuello Principal <yopli2000@gmail.com>
 *
 * This program and its files are under the terms of the license specified in the LICENSE file.
 */
namespace FacturaScripts\Plugins\PruebaPlugin\Controller;

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Core\Lib\ExtendedController\EditController;

/**
 * Controller to edit the items in the ForecastSupplier model
 *
 * @author Jose Antonio Cuello  <yopli2000@gmail.com>
 */
class EditMember extends EditController
{

    private const VIEW_EVENT = "EditEventMember";

    /**
     * Returns the model name
     */
    public function getModelClassName(): string
    {
        return 'Member';
    }

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


        return $pagedata;
    }

    protected function createViews()
    {
        parent::createViews();
        $view = $this->addEditListView(self::VIEW_EVENT, 'EventMember', 'events');
        $view->disableColumn('members');

        $this->setTabsPosition('bottom');
    }

    protected function loadData($viewName, $view)
    {
        switch ($viewName) {
            case self::VIEW_EVENT:
                $mvn = $this->getMainViewName();
                $idmember = $this->getViewModelValue($mvn, 'id');

                $where = [ new DataBaseWhere('idmember', $idmember)];
                $view->loadData('', $where);
                break;
                
            default: 
                parent::loadData($viewName, $view);
                break;
        }
       
    }

}
