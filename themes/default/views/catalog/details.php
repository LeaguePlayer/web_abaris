<?php
    $this->breadcrumbs = array(
        'Каталог абарис'=>array('catalog/index', 'brand'=>$this->brand['alias']),
    );
    if ( $autoModel )
        $this->breadcrumbs[$autoModel->name] = array('/catalog/engines', 'model_id'=>$autoModel->id, 'brand'=>$this->brand['alias']);
    if ( $engineModel )
        $this->breadcrumbs[] = $engineModel->name;
?>

<div class="catalog-container">
    <div class="catalog-model">
        <div class="container">
            <div class="row">
                <?php if ( $autoModel ): ?>
                <div class="span6"><?php if ( $autoModel->hasImage() ) echo $autoModel->getImage('big'); ?></div>
                <div class="span4">
                    <div class="auto-title">
                        <h2><?php echo $autoModel->name; ?></h2>
                        <span><?php echo $autoModel->releaseRange; ?></span>
                    </div>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>

    <div id="top-grid" class="container page-title">
        <h2 class="georgia">Запчасти Абарис</h2>
        <div>
            <span class="blue-line"></span>
        </div>
    </div>

    <div class="parts">
        <div class="container">
            <form action="" class="abaris-form">
                <div class="row">
                    <div class="span3">
                        <label for="">Группа запчастей</label>
                        <?php echo CHtml::activeDropDownList($currentCategory, 'id', CHtml::listData($categories, 'id', 'name'), array('empty'=>'Все', 'class'=>'select_category')); ?>
                        </select>
                    </div>
                </div>
                <?php /*
                <div class="row">
                    <div class="span3">
                        <label for="">Подгруппа запчастей</label>
                        <?php echo CHtml::activeDropDownList($currentSubCategory, 'id', CHtml::listData($childCategories, 'id', 'name'), array('empty'=>'Все', 'class'=>'select_category', 'data-prev'=>$currentCategory->id)); ?>
                        </select>
                    </div>
                </div>
                */ ?>
            </form>
        </div>
    </div>

    <div class="catalog-grid">
        <div class="catalog-grid-header scroll-fixed">
            <div class="container">
                <div class="row-fluid">
                    <?php $form = $this->beginWidget('CActiveForm'); ?>
                    <div class="field span4">
                        <div class="valign-text">
                            <p class="bottom"><?php echo $detailFinder->getAttributeLabel('name');?><br><?php echo $form->textField($detailFinder, 'name'); ?></p>
                        </div>
                    </div>
                    <div class="field span4">
                        <div class="valign-text">
                            <p class="bottom"><?php echo $detailFinder->getAttributeLabel('article');?><br><?php echo $form->textField($detailFinder, 'article'); ?></p>
                        </div>
                    </div>
                    <div class="field span3"></div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>

        <?php $this->widget('zii.widgets.CListView', array(
            'id'=>'details-list',
            'template'=>'{items}<div class="catalog-pager">{pager}</div>',
            'dataProvider'=>$detailsData,
            'itemView'=>'_detail_row',
            'viewData'=>array('autoModel'=>$autoModel, 'engineModel'=>$engineModel),
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