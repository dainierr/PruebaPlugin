<?php
/**
 * This file is part of PrevisionPagos plugin for FacturaScripts.
 * FacturaScripts  Copyright (C) 2015-2022 Carlos Garcia Gomez <carlos@facturascripts.com>
 * PrevisionPagos  Copyright (C) 2022-2024 Jose Antonio Cuello Principal <yopli2000@gmail.com>
 *
 * This program and its files are under the terms of the license specified in the LICENSE file.
 */
namespace FacturaScripts\Plugins\PruebaPlugin\Controller;

use FacturaScripts\Dinamic\Model\Contribution;
use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Core\Lib\ExtendedController\EditController;
use FacturaScripts\Core\Tools;

/**
 * Controller to edit the items in the ForecastSupplier model
 *
 * @author Jose Antonio Cuello  <yopli2000@gmail.com>
 */
class EditContribution extends EditController
{
    private const VIEW_CONTRIBUTION = "EditContribution";

    /**
     * Returns the model name
     */
    public function getModelClassName(): string
    {
        return 'Contribution';
    }

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
        $pagedata['showonmenu'] = false;

        return $pagedata;
    }


}
