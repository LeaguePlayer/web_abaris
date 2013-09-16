<?php
/**
 * Created by JetBrains PhpStorm.
 * User: megakuzmitch
 * Date: 16.09.13
 * Time: 13:03
 * To change this template use File | Settings | File Templates.
 */

class EnginesController extends FrontController
{
    public $layout='//layouts/main';


    public function actionView($id)
    {
        $autoModel = $this->loadModel('AutoModels', $_GET['model_id'], array('with'=>'bodytype'), false);

        $model = $this->loadModel('Details', $id, array('with'=>'analogs'));
        $inStockDetails = array();
        $nonInStockDetails = array();
        if ( $model->in_stock > 0 ) {
            $inStockDetails[] = $model;
        } else {
            $nonInStockDetails[] = $model;
        }
        foreach ( $model->analogs as $analog ) {
            if ( $analog->in_stock > 0 ) {
                $inStockDetails[] = $analog;
            } else {
                $nonInStockDetails[] = $analog;
            }
        }
        $inStockDetailsData = new CArrayDataProvider($inStockDetails, array(
            'pagination'=>array('pageSize'=>100),
        ));
        $nonInStockDetailsData = new CArrayDataProvider($nonInStockDetails, array(
            'pagination'=>array('pageSize'=>100),
        ));

        Yii::app()->clientScript->registerCssFile( $this->getAssetsUrl().'/css/catalog.css' );
        Yii::app()->clientScript->registerScriptFile( $this->getAssetsUrl().'/js/catalog.js', CClientScript::POS_END );
        $this->render('view',array(
            'originalDetail'=>$model,
            'autoModel'=>$autoModel,
            'inStockDetailsData'=>$inStockDetailsData,
            'nonInStockDetailsData'=>$nonInStockDetailsData
        ));
    }
}