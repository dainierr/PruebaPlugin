<?php
/**
 * This file is part of PrevisionPagos plugin for FacturaScripts.
 * FacturaScripts  Copyright (C) 2015-2022 Carlos Garcia Gomez <carlos@facturascripts.com>
 * PrevisionPagos  Copyright (C) 2022-2024 Jose Antonio Cuello Principal <yopli2000@gmail.com>
 *
 * This program and its files are under the terms of the license specified in the LICENSE file.
 */
namespace FacturaScripts\Plugins\PruebaPlugin\Controller;

use FacturaScripts\Dinamic\Model\Visitor;
use FacturaScripts\Dinamic\Model\Member;
use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Core\Lib\ExtendedController\EditController;
use FacturaScripts\Core\Tools;

/**
 * Controller to edit the items in the ForecastSupplier model
 *
 * @author Jose Antonio Cuello  <yopli2000@gmail.com>
 */
class EditVisitor extends EditController
{    

    private const VIEW_VISITOR = "EditVisitor";


    /**
     * Returns the model name
     */
    public function getModelClassName(): string
    {
        return 'Visitor';
    }

    /**
     * Returns basic page attributes
     *
     * @return array
     */
    public function getPageData(): array
    {
        
        $pagedata = parent::getPageData();
        $pagedata['title'] = 'visitors';
        $pagedata['icon'] = 'fa-solid fa-masks-theater';
        $pagedata['menu'] = 'test';

        return $pagedata;
    }

    protected function createViews()
    {
        parent::createViews();  
        $this->addActionVisitor();
       // $this->createViewsVisitors();

       // $this->setTabsPosition('left-bottom');
    }

    protected function execPreviousAction($action)
    {
        switch ($action){
            case 'convert-to-member':
                $this->addVisitorToMemberAction();
                return true;
            
            default :
                return parent::execPreviousAction($action); 
            }
    }
/*
    protected function loadData($viewName, $view)
    {
        switch ($viewName) {
            case self::VIEW_VISITOR:
                $mvn = $this->getMainViewName();
                $idvisitor = $this->getViewModelValue($mvn, 'id');

                $where = [ new DataBaseWhere('idvisitor', $idvisitor)];
                $view->loadData('', $where);
                break;
            default: 
                parent::loadData($viewName, $view);
                break;
        }

    }*/

    private function addActionVisitor():void
    {
        $this->addButton(self::VIEW_VISITOR, [
            'action' => 'convert-to-member',
            'icon' => 'fa-solid fa-masks-theater',
            'label' => 'members',
            'type' => 'action',
            'color' => 'primary',
        ]); 
    }
    
    private function addVisitorToMemberAction():void
    {
        $data=$this->request->request->all();

        if(empty($data['code'])){
            Tools::log()->warning('jo jo jo');
            return;
        }

       // foreach($data['codes'] as $idvisitor){
            $idvisitor = $data['code'];
            $visitor = new Visitor();
            $visitor->loadFromCode($idvisitor);
            $where = [                 
                new DataBaseWhere('name', $visitor->name)
            ];   

            $member= new Member();
            if(false===$member->loadFromCode('', $where)){
                $member->name = $visitor->name;
                $member->surname = '-';
                $member->save();
                Tools::log()->notice('record-updated-correctly');
                 
            }else{
                Tools::log()->warning('ya existe');
                 return;
            }


        //}



    }

    private function createViewsVisitors()
    {
        $view = $this->addEditListView(self::VIEW_VISITOR, 'Visitor', 'visitors');
       // $view->disableColumn('members');
    }









}
