<?php
/**
 * This file is part of PrevisionPagos plugin for FacturaScripts.
 * FacturaScripts Copyright (C) 2015-2022 Carlos Garcia Gomez <carlos@facturascripts.com>
 * PrevisionPagos Copyright (C) 2022-2024 Jose Antonio Cuello Principal <yopli2000@gmail.com>
 *
 * This program and its files are under the terms of the license specified in the LICENSE file.
 */
namespace FacturaScripts\Plugins\PruebaPlugin\Controller;

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Core\Lib\ExtendedController\ListController;
use FacturaScripts\Core\Tools;
use FacturaScripts\Dinamic\Model\ConectionGroupMember;
use FacturaScripts\Dinamic\Model\Member;
use FacturaScripts\Dinamic\Model\Visitor;
use FacturaScripts\Plugins\PrevisionPagos\Lib\PrevisionPagos\ForecastSupplierReport;

/**
 * Controller to list data of Forecast Supplier model.
 *
 * @author Jose Antonio Cuello Principal <yopli2000@gmail.com>
 */
class ListMember extends ListController
{

    private const VIEW_MEMBER = 'ListMember';
    private const VIEW_EVENT = 'ListVisitor';

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
        $pagedata['ordernum'] = 0;

        return $pagedata;
    }

    /**
     * Load views
     */
    protected function createViews()
    {
        $this->createViewMembers();
        $this->createViewVisitors();
       
    }

    protected function execPreviousAction($action)
    {
        switch ($action){
            case 'add-group':
                $this->addGroupAction();
                return true;
            case 'convert-to-member':
                $this->convertToMember();
                return true;

            default :
                return parent::execPreviousAction($action);  
        }
    }

    /**
     * Add and configure absence concept view
     *
     * @param string $viewName
     */
    private function createViewMembers($viewName = self::VIEW_MEMBER):void
    {
        $this->addView($viewName, 'Member', 'members', 'fa-solid fa-user-groupy');
        $this->addSearchFields($viewName, ['name', 'id', 'surname']);

        $this->addOrderBy($viewName, ['id'], 'code');
        $this->addOrderBy($viewName, ['name', 'surname'], 'name', 1); 
        $this->addButton($viewName, [
            'action' => 'add-group',
            'icon' => 'fa-solid fa-masks-theater',
            'label' => 'conectiongroup',
            'type' => 'modal',
            'color' => 'primary',
        ]);  
        
            
        
    }

    /**
     * Add and configure absence concept view
     *
     * @param string $viewName
     */
    private function createViewVisitors($viewName = self::VIEW_EVENT):void
    {
        $this->addView($viewName, 'Visitor', 'visitors', 'fa-solid fa-masks-theater');
        $this->addSearchFields($viewName, ['name', 'id', 'phone']);

        $this->addOrderBy($viewName, ['id'], 'code', 2);
        $this->addOrderBy($viewName, ['name'], 'name', 1);  
        
        $this->addButton($viewName, [
            'action' => 'convert-to-member',
            'icon' => 'fa-solid fa-masks-theater',
            'label' => 'members',
            'type' => 'action',
            'color' => 'primary',
        ]); 
        
    }

    /**
     * 
     */
    private function addGroupAction():void
    {
        if(false === $this->validateFormToken()){
            return;
        }
        $data=$this->request->request->all();
        if(empty($data['code'])){
            Tools::log()->warning('no-code-list');
            return;
        }

        $idconectiongroup = (int)$data['idconectiongroup'] ?? 0;
        if(empty($idconectiongroup)){
            Tools::log()->warning('no-idconectiongroup');
            return;
        }

        $count = $total = 0;
        foreach(explode(',',$data['code']) as $idmember){
            $total++;
            $where = [ 
                new DataBaseWhere('idconectiongroup', $idconectiongroup),
                new DataBaseWhere('idmember', $idmember)
            ];            

            $conectiongmember= new ConectionGroupMember();
            if(false===$conectiongmember->loadFromCode('', $where)){
                $conectiongmember->idconectiongroup = $data['idconectiongroup'];
                $conectiongmember->idmember = $idmember;
                $conectiongmember->save();
                $count++;   
            }
           
        }

        Tools::log()->info(
            'add-member-conection', ['%count%'=>$count,'%total%'=>$total]
        );

    }
    private function convertToMember():void
    {
        $data=$this->request->request->all();

        if(empty($data['codes'])){
            Tools::log()->warning('no-code-list');
            return;
        }
        
        foreach($data['codes'] as $idvisitor){
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


        }
    }
    

}
