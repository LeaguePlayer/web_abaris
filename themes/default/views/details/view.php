<?php
    $this->breadcrumbs = array(
        $this->brand['name']=>array('/catalog'),
    );
    if ( isset($autoModel) ) {
        $this->breadcrumbs[$autoModel->name] = array('/catalog/engines', 'model_id'=>$autoModel->id);
        if ( isset($engineModel) ) {
            $this->breadcrumbs[$engineModel->name] = array('/catalog/details', 'model_id'=>$autoModel->id, 'engine_id'=>$engineModel->id, 'cat'=>$_GET['cat']);
        }
    }
    $this->breadcrumbs[] = $findedDetail->name;
?>

<div class="catalog-container">
    <div class="catalog-model">
        <div class="container">
            <div class="row">
                <div class="span6"><?php if ($autoModel) echo $autoModel->getImage('big'); ?></div>
                <div class="span4">
                    <div class="auto-title">
                        <h2><?php echo $autoModel->name; ?></h2>
                        <span><?php echo $autoModel->releaseRange; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ( $inStockDetailsData->totalItemCount > 0 ) {
        $this->renderPartial('_catalog_grid', array(
            'title' => 'Детали в наличии',
            'findedDetail'=>$findedDetail,
            'detailsData' => $inStockDetailsData,
            'firstAnalogId'=>$firstAnalogInStockId,
        ));
    } ?>

    <?php if ( $nonInStockDetailsData->totalItemCount > 0 ) {
        $this->renderPartial('_catalog_grid', array(
            'title' => 'Вы можете заказать детали, если их нет в наличии',
            'findedDetail'=>$findedDetail,
            'detailsData' => $nonInStockDetailsData,
            'firstAnalogId'=>$firstAnalogNonInStockId,
        ));
    } ?>
</div>