<?php
    $this->breadcrumbs = array(
        $this->brand['name']=>array('/catalog'),
    );
    if ( !empty($_GET['model_id']) ) {
        $this->breadcrumbs['Каталог Абарис'] = array('/catalog/details', 'model_id'=>$_GET['model_id'], 'cat'=>$_GET['cat']);
    }
    $this->breadcrumbs[] = $originalDetail->name;
?>

<div class="catalog-container">
    <div class="catalog-model">
        <div class="container">
            <div class="row">
                <div class="span6"><?php if ($autoModel) echo $autoModel->getImage('big'); ?></div>
                <div class="span4">
                    <div class="auto-title">
                        <h2><?php echo $autoModel->name; ?></h2>
                        <span><?php echo $autoModel->releaseYear.' - '.$autoModel->endReleaseYear; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ( $inStockDetailsData->totalItemCount > 0 ) {
        $this->renderPartial('_catalog_grid', array(
            'detailsData' => $inStockDetailsData,
        ));
    } ?>

    <?php if ( $nonInStockDetailsData->totalItemCount > 0 ) {
        $this->renderPartial('_catalog_grid', array(
            'title' => 'Вы можете заказать детали, если их нет в наличии',
            'detailsData' => $nonInStockDetailsData,
        ));
    } ?>
</div>