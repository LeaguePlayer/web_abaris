<?php
$this->breadcrumbs = array(
    'Каталог абарис'=>array('catalog/index', array('brand'=>$this->brand['alias'])),
    $autoModel->name,
);
?>

<!-- begin engine-->
<div class="engine-model">
    <div class="container">
        <div class="row">
            <div class="span4 img"><?php echo $autoModel->getImage('big'); ?></div>
            <div class="span4">
                <h2 class="georgia"><?php echo $autoModel->name; ?></h2>
                <p><?php echo '<span class="grey">'.$autoModel->releaseYear.'</span> - '.$autoModel->endReleaseYear; ?></p>
                <?php foreach ( $autoModel->detailInfo as $item ): ?>
                <div class="row">
                    <div class="span2"><?php echo $item['label']; ?></div>
                    <div class="span2 grey"><?php echo $item['value']; ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<div class="catalog-container">
    <div class="catalog-grid">
        <div class="catalog-grid-header">
            <div class="container">
                <div class="row-fluid">
                    <div class="field span2">
                        <div class="valign-text"><p>Объем двигателя</p></div>
                    </div>
                    <div class="field span2">
                        <div class="valign-text"><p>Топливо</p></div>
                    </div>
                    <div class="field span2">
                        <div class="valign-text"><p>Мощность Л.С.</p></div>
                    </div>
                    <div class="field span4">
                        <div class="valign-text"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->widget('zii.widgets.CListView', array(
            'id'=>'engines-list',
            'template'=>'{items}<div class="catalog-pager">{pager}</div>',
            'dataProvider'=>$enginesDataProvider,
            'itemView'=>'_engine_row',
            'viewData'=>array('autoModel'=>$autoModel, 'currentEngineId'=>$currentEngineId),
            'pagerCssClass'=>'container',
            'emptyTagName'=>'div',
            'updateSelector'=>'.catalog-pager a',
            'pager'=>array(
                'class'=>'application.widgets.ELinkPager',
                'cssFile'=>false,
                'header'=>'',
                'firstPageLabel'=>'',
                'prevPageLabel'=>'',
                'previousPageCssClass'=>'arrow left',
                'nextPageLabel'=>'',
                'nextPageCssClass'=>'arrow right',
                'lastPageLabel'=>'',
                'htmlOptions'=>array(
                    'class'=>''
                ),
            )
        )); ?>
    </div>
</div>
<div class="engine-info">
    <div class="container">
        <div class="row">
            <div class="span12">
                Затрудняетесь выбрать или не знаете где посмотреть эти данные позвоните нам: <span>+7 <span class="red">(<?=Settings::getOption('code')?>)</span> <?=Settings::getOption('phone')?></span>
            </div>
        </div>
        <div class="row">
            <div class="span1">Или</div>
            <div class="span4">
                <a href="<?php echo $this->createUrl('/site/feedback'); ?>" class="b-button b-button-blue feedback">Напишите нам</a>
            </div>
        </div>
    </div>
</div>
<!-- end engine -->