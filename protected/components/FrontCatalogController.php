<?php

class FrontCatalogController extends FrontController
{
    protected function push_depot_positions(&$stockArray, Details $model)
    {
        foreach ( $model->depotPositions as $depotPosition ) {
            if ( $depotPosition->stock == 0 )
                continue;
            $position = $model->duplicate();
            $position->in_stock = $depotPosition->stock;
            $position->price = $depotPosition->price;
            $position->delivery_time = 0;
            $position->virtualType = Details::VIRTUALTYPE_DEPOT;
            $position->virtualId = $depotPosition->depot_id;
            $stockArray[] = $position;
        }
    }

    protected function push_provider_positions(&$stockArray, Details $model)
    {
        foreach ( $model->providerPositions as $providerPosition ) {
            if ( $providerPosition->stock == 0 )
                continue;
            $position = $model->duplicate();
            $position->in_stock = $providerPosition->stock;
            $position->price = $providerPosition->price;
            $position->delivery_time = $providerPosition->delivery_time;
            $position->virtualType = Details::VIRTUALTYPE_PROVIDER;
            $position->virtualId = $providerPosition->provider_id;
            $stockArray[] = $position;
        }
    }
}