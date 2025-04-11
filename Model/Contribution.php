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
use FacturaScripts\Core\Session;
use FacturaScripts\Core\Tools;


/**
 * Class that manages the data model of the forecast of suppliers.
 *
 * @author Dainier Rojas Jiménez  <danredjim@gmail.com>
 */
class Contribution extends ModelClass
{

    use ModelTrait;

    public const TITHE_DIEZMO = 1;
    public const TITHE_OFRENDA = 2;
    public const TITHE_ESPECIAL = 3;

    public const PAYMENT_EFECTIVO = 1;
    public const PAYMENT_TRANSFERENCIA = 2;
    public const PAYMENT_TARJETA = 3;

    /** Primary Key of the model @var int */
    public $id;



    /**
     *Contributions registration
     * @var string
     */
    public $registration;

    /**
     *Contributions  amount.
     *
     * @var int
     */
    public $amount;


   /**
     * Contributions tithetype.
     *
     * @var int
     */
    public $tithetype;

    /**
     *Contributions paymentmethod.
     *
     * @var int
     */
    public $paymentmethod;

    /**
     * Contributions idmember.
     *
     * @var int
     */
    public $idmember;

        /**
     *Contributions tithename
     * @var string
     */
    public $tithename;
    /**
     * 
     */
    public $nick;

    /**
     * 
     */
    public function clear()
    {
        parent::clear();
        $this->registration = date(self::DATE_STYLE);
        $this->amount = 0;
        $this->tithetype = self::TITHE_DIEZMO;
        $this->paymentmethod = self::PAYMENT_TRANSFERENCIA;   
        $this->nick = Session::user()->nick;   
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
        return 'contributions';
    }

    /**
     * Returns true if there are no errors in the values of the model properties.
     * It runs inside the save method.
     *
     * @return bool
     */
    public function test(): bool
    {   
        if($this->amount <= 0){
            Tools::log()->error('import-error');
            return false;
        }
        if($this->tithetype == self::TITHE_ESPECIAL && empty($this->tithename)){
            Tools::log()->error('tithename-required');
            return false;
        }
        if(false === empty($this->idmember)){
            $member= new Member();
            $member->loadFromCode($this->idmember);
            if(empty($member->cifnif)){
                Tools::log()->error('cif-required');
                 return false;
            }
        }

        return parent::test();
    }

}
