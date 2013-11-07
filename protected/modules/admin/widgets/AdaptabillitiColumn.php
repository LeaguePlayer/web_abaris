<?php
/**
 * Created by JetBrains PhpStorm.
 * User: megakuzmitch
 * Date: 06.11.13
 * Time: 15:50
 * To change this template use File | Settings | File Templates.
 */

class AdaptabillitiColumn extends CGridColumn
{
    public function renderDataCellContent($row, $data)
    {
        echo TbHtml::link('Редактировать', array('adaptabilliti', 'detail_id'=>$data->id), array(
            'class'=>'link-modal'
        ));
    }
}