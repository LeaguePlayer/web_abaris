<?php

class DetailsController extends FrontController
{
	public $layout='//layouts/main';

	
	public function actionView($id = false, $article = false)
	{
        $autoModel = $this->loadModel('AutoModels', $_GET['model_id'], array('with'=>array('bodytype', 'engines', 'engine')), false);
        if ( !empty($_GET['engine_id']) ) {
            foreach ( $this->engines as $engine) {
                if ( $engine->id === $_GET['engine_id'] ) {
                    $engineModel = $engine;
                    break;
                }
            }
        } else {
            $engineModel = $autoModel->engine;
        }

        $criteria = new CDbCriteria();
        $criteria->with = 'analogs';
        if ( $id ) {
            $criteria->compare('t.id', $id);
        } else if ( $article ) {
            $criteria->compare('t.article', $article);
        } else {
            throw new CHttpException(404, 'Страница не найдена');
        }
        $model = Details::model()->find($criteria);
        if ( $model === null ) {
            throw new CHttpException(404, 'Страница не найдена');
        }

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
            'engineModel'=>$engineModel,
			'inStockDetailsData'=>$inStockDetailsData,
            'nonInStockDetailsData'=>$nonInStockDetailsData,
		));
	}
}
