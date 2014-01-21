<?php $this->widget('zii.widgets.CListView', array(
    'id'=>'cars-list',
    'template'=>'{items}',
    'dataProvider'=>$dataUserListCars,
    'itemView'=>'_item_list_cars_user',
    'emptyTagName'=>'div',
    'emptyText'=>'<div class="container">Нет автомобилей</div>',
    'updateSelector'=>'.catalog-pager a',
)); ?>