<?php
    if ( $data->in_stock > 0 ) {
        foreach ( $data->depotPositions as $depotPosition ) {
            if ( $depotPosition->stock == 0 )
                continue;

            $position = $data->duplicate();
            $position->in_stock = $depotPosition->stock;
            $position->price = $depotPosition->price;
            $position->delivery_time = 0;
            $position->virtualType = Details::VIRTUALTYPE_DEPOT;
            $position->virtualId = $depotPosition->depot_id;

            $this->renderPartial('//details/_grid_row', array(
                'data'=>$position,
                'searchedId'=>$searchedId,
            ));
        }
    } else if ( count($data->providerPositions) > 0 ) {
        foreach ( $data->providerPositions as $providerPosition ) {
            if ( $providerPosition->stock == 0 )
                continue;

            $position = $data->duplicate();
            $position->in_stock = $providerPosition->stock;
            $position->price = $providerPosition->price;
            $position->delivery_time = $providerPosition->delivery_time;
            $position->virtualType = Details::VIRTUALTYPE_PROVIDER;
            $position->virtualId = $providerPosition->provider_id;

            $this->renderPartial('//details/_grid_row', array(
                'data'=>$position,
                'searchedId'=>$searchedId,
            ));
        }
    } else {
        $this->renderPartial('//details/_grid_row', array(
            'data'=>$data,
            'searchedId'=>$searchedId,
        ));
    }
?>

