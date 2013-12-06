<?php
    if ( $data->in_stock > 0 ) {
        foreach ( $data->depotPositions as $depotPosition ) {
            if ( $depotPosition->stock == 0 )
                continue;

            $position = new Details('duplicate');
            $position->attributes = $data->attributes;
            $position->in_stock = $depotPosition->stock;
            $position->delivery_time = 0;
            $position->virtualType = Details::VIRTUALTYPE_DEPOT;
            $position->virtualId = $depotPosition->depot_id;
            //$position->depotName = $depo

            $this->renderPartial('_grid_row', array(
                'data'=>$position,
                'searchedId'=>$searchedId,
            ));
        }
    } else if ( count($data->providerPositions) > 0 ) {
//        foreach ( $data->providerPositions as $providerPosition ) {
//            $this->renderPartial('_grid_row', array(
//                'data'=>$data,
//                'deliveryTime'=>$providerPosition->delivery_time,
//                'stock'=>$providerPosition->stock,
//                'price'=>$providerPosition->price,
//            ));
//        }
    } else {
        $this->renderPartial('_grid_row', array(
            'data'=>$data,
            'searchedId'=>$searchedId,
        ));
    }
?>

