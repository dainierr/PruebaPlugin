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
namespace FacturaScripts\Plugins\PruebaPlugin\Model;

use FacturaScripts\Core\Model\Base\ModelClass;
use FacturaScripts\Core\Model\Base\ModelTrait;
use FacturaScripts\Core\Tools;


/**
 * Class that manages the data model of the forecast of suppliers.
 *
 * @author Dainier Rojas Jiménez  <danredjim@gmail.com>
 */
class Visitor extends ModelClass
{

    use ModelTrait;

    /** Primary Key of the model @var int */
    public $id;

    /**
     * Event name.
     *
     * @var string
     */
    public $name;

    /**
     * 
     * @var string
     */
    public $phone;

    /**
     * 
     * @var string
     */
    public $dischargedate;

    /**
     * 
     * @var string
     */
    public $comments;

    /**
     * 
     *
     * @var int
     */
    public $idmember;

    /**
     * 
     */
    public function clear()
    {
        parent::clear();
        $this->dischargedate = date(self::DATE_STYLE);
    }


    /**
     * Returns the name of the column that is the model's primary key.
     *
     * @return string
     */
    public static function primaryColumn(): string
    {
        return 'id';
    }

    /**
     * Returns the name of the table that uses this model.
     *
     * @return string
     */
    public static function tableName(): string
    {
        return 'visitors';
    }

    /**
     * Returns true if there are no errors in the values of the model properties.
     * It runs inside the save method.
     *
     * @return bool
     */
    public function test(): bool
    {
        $this->name = Tools::noHtml($this->name);

        return parent::test();
    }
    /**
     * 
     */
    public function url(string $type = 'auto', string $list = 'ListMember?activetab=List'): string
    {
        return parent::url($type, $list);
    }

}
