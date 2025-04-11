<?php
/**
 * This file is part of PrevisionPagos plugin for FacturaScripts
 * Copyright (C) 2015-2022 Carlos Garcia Gomez <carlos@facturascripts.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
namespace FacturaScripts\Plugins\PruebaPlugin\Model\Join;

use FacturaScripts\Core\Model\Base\JoinModel;
use FacturaScripts\Dinamic\Model\Contribution as ModelContribution;

/**
 * Class that manages the data model of the forecast of suppliers.
 *
 * @author Dainier Rojas Jiménez  <danredjim@gmail.com>
 */
class Contribution extends JoinModel
{

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->setMasterModel(new ModelContribution());
      
    }
    
    protected function getFields(): array
    {
        return [
            'id' => 'contributions.id',
            'registration' => 'contributions.registration',
            'paymentmethod' => 'contributions.paymentmethod',
            'amount' => 'contributions.amount',
            'tithetype' => 'contributions.tithetype',
            'tithename' => 'contributions.tithename',            
            'idmember' => 'contributions.idmember',
            'nick' => 'contributions.nick',
            'member' => 'members.name',
            'cifnif' => 'members.cifnif',
         
        ];
    }

    protected function getSQLFrom(): string
    {
        return 'contributions'
        . ' LEFT JOIN members ON contributions.idmember = members.id';
    }

    protected function getTables(): array
    {
        return [];
    }




}