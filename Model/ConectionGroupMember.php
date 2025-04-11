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

/**
 * Class that manages the data model of the forecast of suppliers.
 *
 * @author Dainier Rojas Jiménez  <danredjim@gmail.com>
 */
class ConectionGroupMember extends ModelClass
{

    use ModelTrait;

    /** @var int */
    public $id;

    /** @var int */
    public $idconectiongroup;

   /** @var int */
   public $idmember;



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
        return 'conection_groups_members';
    }

    /**
     * 
     */
    /*ACTUALIZACION MEDIANTE MODELO*/
    /*protected function saveInsert(array $values=[]): bool
    {
        if(false===parent::saveInsert($values)){
            return false;
        }
        $group = new ConectionGroup();
        $group->loadFromCode($this->idconectiongroup);
        $group->membernumbers++;

        return $group->save();
    }*/
 
    /*public function delete(): bool
    {
        if(false===parent::delete()){
            return false;
        }
        $group = new ConectionGroup();
        $group->loadFromCode($this->idconectiongroup);
        $group->membernumbers--;

        return $group->save();
    }*/

    protected function saveInsert(array $values=[]): bool
    {
        if(false===parent::saveInsert($values)){
            return false;
        }          
        return $this->updateMemberNumber();
    }

    public function delete(): bool
    {
        if(false===parent::delete()){
            return false;
        }  
        return $this->updateMemberNumber();
    }

    private function updateMemberNumber(): bool
    {
        $sql1 = 'SELECT COUNT(*) FROM ' .$this->tableName() . ' WHERE idconectiongroup = '.$this->idconectiongroup;   
        $sql2 = 'UPDATE ' . ConectionGroup::tableName() . ' SET membernumbers = (' . $sql1 . ') WHERE id = '.$this->idconectiongroup;
        return self::$dataBase->exec($sql2);
    }
}
