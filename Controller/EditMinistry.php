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
class EditMinistry extends EditController
{    

    /**
     * Returns the model name
     */
    public function getModelClassName(): string
    {
        return 'Ministry';
    }

    /**
     * Returns basic page attributes
     *
     * @return array
     */
    public function getPageData(): array
    {

        $pagedata = parent::getPageData();
        $pagedata['title'] = 'ministries';
        $pagedata['icon'] = 'fa-solid fa-masks-theater';
        $pagedata['menu'] = 'test';

        return $pagedata;
    }




    





}
