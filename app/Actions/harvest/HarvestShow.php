<?php

namespace App\Actions\harvest;

class HarvestShow
{
    private $harvestAction;
    public function __construct()
    {
        $this->harvestAction = new HarvestAction();
    }

    public function HarvestShow($harvest_show):array
    {
        $show = [];
        foreach ($harvest_show as $id => $value){
            if($this->harvestAction->HarvestYear(now()) == $id){
                $show [$id] = true;
            } else{
                $show [$id] = false;
            }
        }
        return $show;
    }
}
