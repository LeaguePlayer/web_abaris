<?php if ( $detailsData->totalItemCount > 0 ): ?>
    <?php if ( $title ): ?>
        <div class="container page-title">
            <h2 class="georgia"><?php echo $title ?></h2>
            <div><span class="blue-line"></span></div>
        </div>
    <?php endif ?>
    <?php $this->widget('zii.widgets.CListView', array(
        'id'=>'details-list',
        'template'=>'{items}<div class="catalog-pager">{pager}</div>',
        'dataProvider'=>$detailsData,
        'itemView'=>'//details/_view',
        'viewData'=>array('searchedId' => $searchedId),
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
<?php endif ?>