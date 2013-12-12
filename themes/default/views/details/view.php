<?php
    $this->breadcrumbs = array(
        $this->brand['name']=>array('catalog/index', 'brand'=>$this->brand['alias']),
    );
    if ( isset($autoModel) ) {
        $this->breadcrumbs[$autoModel->name] = array('catalog/engines', 'model_id'=>$autoModel->id, 'brand'=>$this->brand['alias']);
        if ( isset($engineModel) ) {
            $this->breadcrumbs[$engineModel->name] = array('catalog/details', 'model_id'=>$autoModel->id, 'engine_id'=>$engineModel->id, 'cat'=>$_GET['cat'], 'brand'=>$this->brand['alias']);
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

    <div class="catalog-grid">
        <div class="catalog-grid-header scroll-fixed">
            <div class="container">
                <div class="row-fluid">
<!--                    <div class="field span1"><div class="valign-text"><p>Фото продукта</p></div></div>-->
                    <div class="field span2"><div class="valign-text"><p>Бренд</p></div></div>
                    <div class="field span2"><div class="valign-text"><p>Артикул</p></div></div>
                    <div class="field span2"><div class="valign-text"><p>Наименование</p></div></div>
                    <div class="field span2"><div class="valign-text"><p>В наличии</p></div></div>
                    <div class="field span1"><div class="valign-text"><p>Срок доставки</p></div></div>
                    <div class="field span2"><div class="valign-text"><p>Цена</p></div></div>
                    <div class="field span1"><div class="valign-text"><p>В корзину</p></div></div>
                </div>
            </div>
        </div>

        <?php $this->renderPartial('_catalog_grid', array(
            'title' => 'Запрошенный артикул',
            'detailsData' => new CArrayDataProvider(array($findedDetail)),
            'searchedId' => $findedDetail->id,
        ))  ?>

        <?php $this->renderPartial('_catalog_grid', array(
            'title' => 'Детали в наличии',
            'detailsData' => $inStockDetailsData,
            'searchedId' => $findedDetail->id,
        ))  ?>

        <?php $this->renderPartial('_catalog_grid', array(
            'title' => 'Вы можете заказать детали, если их нет в наличии',
            'detailsData' => $nonInStockDetailsData,
            'searchedId' => $findedDetail->id,
        ))  ?>
    </div>
</div>