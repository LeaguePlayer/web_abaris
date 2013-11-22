<?php if ($data->id === $findedDetail->id): ?>
    <div class="catalog-grid-subhead">
        <div class="container">
            <h3>Запрошенный артикул</h3>
        </div>
    </div>
<?php elseif ( $data->id === $firstAnalogId ): ?>
    <div class="catalog-grid-subhead">
        <div class="container">
            <h3>Список аналогов</h3>
        </div>
    </div>
<?php endif ?>

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

            $this->renderPartial('_grid_row', array(
                'findedDetail'=>$findedDetail,
                'model'=>$position,
            ));
        }
    } else if ( count($data->providerPositions) > 0 ) {
        foreach ( $data->providerPositions as $providerPosition ) {
            $this->renderPartial('_grid_row', array(
                'findedDetail'=>$findedDetail,
                'model'=>$data,
                'deliveryTime'=>$providerPosition->delivery_time,
                'stock'=>$providerPosition->stock,
                'price'=>$providerPosition->price,
            ));
        }
    } else {
        $this->renderPartial('_grid_row', array(
            'findedDetail'=>$findedDetail,
            'model'=>$data,
            'deliveryTime'=>'–',
            'stock'=>$data->in_stock,
            'price'=>$data->price,
        ));
    }
?>

