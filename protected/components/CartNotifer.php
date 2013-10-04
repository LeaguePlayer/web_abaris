<?php
/**
 * Created by JetBrains PhpStorm.
 * User: megakuzmitch
 * Date: 20.09.13
 * Time: 9:40
 * To change this template use File | Settings | File Templates.
 */

class CartNotifer
{
    public static function updatePosition($event)
    {
        $position = $event->params['targetPosition'];
        Yii::app()->user->updateCartPosition($position);
    }

    public static function removePosition($event)
    {
        $key = $event->params['targetKey'];
        Yii::app()->user->removeCartPosition($key);
    }
}