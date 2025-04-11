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
use FacturaScripts\Core\Tools;
use FacturaScripts\Plugins\PruebaPlugin\Model\Contribution;
use FacturaScripts\Dinamic\Model\TotalModel;

/**
 * Controller to edit the items in the ForecastSupplier model
 *
 * @author Jose Antonio Cuello  <yopli2000@gmail.com>
 */
class EditMember extends EditController
{

    private const VIEW_EVENT = "EditEventMember";
    private const VIEW_NOTES = "EditMemberNote";
    private const VIEW_CONTRIBUTION = "ListContribution";

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
    
    public function calcTotalDistribution(): string
    {
        return Tools::money($this->getTotalFromTotalModel());
    }

    protected function createViews()
    {
        parent::createViews();   
         
        $this->createViewsEvents(); 
        $this->createViewsNotes();
        $this->createViewsContributions();

        $this->setTabsPosition('left-bottom');
    }

    protected function loadData($viewName, $view)
    {
        switch ($viewName) {
            case self::VIEW_EVENT:
            case self::VIEW_CONTRIBUTION:
                $mvn = $this->getMainViewName();
                $idmember = $this->getViewModelValue($mvn, 'id');

                $where = [ new DataBaseWhere('idmember', $idmember)];
                $view->loadData('', $where);
                break;
            case self::VIEW_NOTES:
                $view->model = $this->getModel();
                
                break;
            default: 
                parent::loadData($viewName, $view);
                break;
        }
       
    }

  private function createViewsEvents()
    {  
        $view = $this->addEditListView(self::VIEW_EVENT, 'EventMember', 'events');
        $view->disableColumn('members');
    }
    private function createViewsNotes()
    {
        $view = $this->addEditView(self::VIEW_NOTES, 'Member', 'notes');
        $view->setSettings('btnDelete',false);
    }
    private function createViewsContributions()
    {
        $view = $this->addListView(self::VIEW_CONTRIBUTION, 'Contribution', 'contributions');
        $view->disableColumn('members');
        $view->addOrderBy(['registration'],'date' ,2 );
        $view->addFilterPeriod('date', 'date', 'registration');
    }

    private function getTotalFromSql():string
    {       
        $sql1 = 'SELECT SUM(amount) AS total FROM ' .Contribution::tableName() . ' WHERE idmember = '.$this->getModel()->id;         
        $data = $this->dataBase->select($sql1);
        return empty($data[0]['total']) ? '0': $data[0]['total'];
    }
   

    private function getTotalFromModel():string
    {
        $total = 0;

        $where = [new DataBaseWhere('idmember', $this->getModel()->id)];
        foreach (Contribution::all($where,[],0,0) as $contribution){
            $total += $contribution->amount;
        }
        return $total;
    }

    private function getTotalFromTotalModel():string
    {
       
        return  TotalModel::sum(
            Contribution::tableName(),
            'amount',
            [
                new DataBaseWhere('idmember', $this->getModel()->id)
        ]);
    }
}
