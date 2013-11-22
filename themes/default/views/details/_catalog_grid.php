<?php if ( !empty($title) ): ?>
<div class="container page-title">
    <h2 class="georgia"><?php echo $title; ?></h2>
    <div>
        <span class="blue-line"></span>
    </div>
</div>
<? endif; ?>


<div class="catalog-grid">
    <div class="catalog-grid-header scroll-fixed">
        <div class="container">
            <div class="row-fluid">
                <div class="field span1"><div class="valign-text"><p>Фото продукта</p></div></div>
                <div class="field span2"><div class="valign-text"><p>Бренд</p></div></div>
                <div class="field span2"><div class="valign-text"><p>Артикул</p></div></div>
                <div class="field span2"><div class="valign-text"><p>Наименование</p></div></div>
                <div class="field span2"><div class="valign-text"><p>В наличии (Адрес)</p></div></div>
                <div class="field span1"><div class="valign-text"><p>Срок доставки</p></div></div>
                <div class="field span2"><div class="valign-text"><p>Цена</p></div></div>
            </div>
        </div>
    </div>
    <?php $this->widget('zii.widgets.CListView', array(
        'id'=>'details-list',
        'template'=>'{items}<div class="catalog-pager">{pager}</div>',
        'dataProvider'=>$detailsData,
        'itemView'=>'_view',
        'viewData'=>array('findedDetail'=>$findedDetail, 'firstAnalogId' => $firstAnalogId),
        'pagerCssClass'=>'container',
        'emptyTagName'=>'div',
        'emptyText'=>'',
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