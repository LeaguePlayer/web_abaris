<?php
$this->breadcrumbs = array(
    'Каталог аксессуаров',
);
?>

<div class="catalog-container">
    <div class="catalog-model">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </div>

    <div id="top-grid" class="container page-title">
        <h2 class="georgia">Аксессуары</h2>
        <div>
            <span class="blue-line"></span>
        </div>
    </div>

    <div class="catalog-grid">
        <div class="catalog-grid-header scroll-fixed">
            <div class="container">
                <div class="row-fluid">
                    <?php $form = $this->beginWidget('CActiveForm'); ?>
                    <div class="field span4">
                        <div class="valign-text">
                            <p class="bottom"><?php echo $finder->getAttributeLabel('name');?><br><?php echo $form->textField($finder, 'name'); ?></p>
                        </div>
                    </div>
                    <div class="field span4">
                        <div class="valign-text">
                            <p class="bottom"><?php echo $finder->getAttributeLabel('article');?><br><?php echo $form->textField($finder, 'article'); ?></p>
                        </div>
                    </div>
                    <div class="field span3"></div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>

        <?php $this->widget('zii.widgets.CListView', array(
            'id'=>'acessory-list',
            'template'=>'{items}<div class="catalog-pager">{pager}</div>',
            'dataProvider'=>$dataProvider,
            'itemView'=>'_accessory_row',
            'pagerCssClass'=>'container',
            'emptyTagName'=>'div',
            'emptyText'=>'<div class="container">По вашему запросу ничего не найдено</div>',
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