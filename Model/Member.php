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
class Member extends ModelClass
{

    use ModelTrait;

    /** @var int */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $surname;
    
    /**
     * 
     * @var string
     */
    public $phone1;

    /**
     * 
     * @var string
     */
    public $email;
        
    /**
     * 
     * @var string
     */
    public $birthdate;
    /**
     * 
     * @var string
     */
    public $baptism;

    /**
     * 
     * @var string
     */
    public $notes;
    /**
     * 
     * @var int
     */
    public $gender;
    /**
     * 
     * @var int
     */
    public $marital;
    /**
     * 
     * @var boolean
     */
    public $active;

    /**
     * 
     *
     * @var int
     */
    public $idministry;

    /**
     * 
     */
    public function clear()
    {
        parent::clear();
        $this->gender = 1;
        $this->marital = 1;
        $this->active = true;

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
        return 'members';
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
        $this->surname = Tools::noHtml($this->surname);

        return parent::test();
    }

}
