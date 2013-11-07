<?php
$this->breadcrumbs = array(
    'Каталог аксессуаров',
);
?>

<div class="catalog-container">
    <div class="catalog-model">
        <div class="container">
            <div class="row">
                <div class="span6"></div>
                <div class="span4">
                    <div class="auto-title">
                        <h2></h2>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container page-title">
        <h2 class="georgia">Аксессуары</h2>
        <div>
            <span class="blue-line"></span>
        </div>
    </div>

    <div class="catalog-grid">
        <div class="catalog-grid-header">
            <div class="container">
                <div class="row-fluid">
                    <div class="field span2"><div class="valign-text"><p>Фото продукта</p></div></div>
                    <div class="field span1"><div class="valign-text"><p>Бренд</p></div></div>
                    <div class="field span2"><div class="valign-text"><p>Артикул</p></div></div>
                    <div class="field span2"><div class="valign-text"><p>Наименование</p></div></div>
                    <div class="field span2"><div class="valign-text"><p>В наличии</p></div></div>
                    <div class="field span1"><div class="valign-text"><p>Срок доставки</p></div></div>
                    <div class="field span2"><div class="valign-text"><p>Цена</p></div></div>
                </div>
            </div>
        </div>
        <?php $this->widget('zii.widgets.CListView', array(
            'id'=>'details-list',
            'template'=>'{items}<div class="catalog-pager">{pager}</div>',
            'dataProvider'=>$dataProvider,
            'itemView'=>'_view',
            'pagerCssClass'=>'container',
            'emptyTagName'=>'div',
            'emptyText'=>'<div class="container">Нет аксессуаров</div>',
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