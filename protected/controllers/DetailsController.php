<?php

class DetailsController extends FrontController
{
	public $layout='//layouts/main';

	
	public function actionView($id = false, $article = false, $model_id = false, $engine_id = false)
	{
        $autoModel = $this->loadModel('AutoModels', $model_id, array('with'=>array('bodytype', 'engines')), false);
        if ( !empty($engine_id) ) {
            foreach ( $autoModel->engines as $engine) {
                if ( $engine->id === $engine_id ) {
                    $engineModel = $engine;
                    break;
                }
            }
        }

        $criteria = new CDbCriteria();
        $criteria->with = array(
            'analogs',
            'depotPositions'=>array(
                'with'=>'depot',
            ),
            'providerPositions'
        );
        if ( $id ) {
            $criteria->compare('t.id', $id);
        } else if ( $article ) {
            $criteria->compare('t.article_alias', $article);
            //$criteria->addCondition("t.article LIKE ':article%' OR t.article_alias LIKE ':article%'");
            //$criteria->params[':article'] = $article;
        } else {

        }

        $model = Details::model()->find($criteria);
        if ( $model === null ) {
			// ЕСЛИ ЗАПЧАСТЬ НЕ НАЙДЕНА
			$detailNotFound = Details::detailNotFound($article);
            $this->render('nofounddetail', array('detailNotFound'=>$detailNotFound) );
			throw new CHttpException(404, 'Запчасть не найдена');
        }


        $inStockDetails = array();
        $nonInStockDetails = array();
        if ( $model->in_stock > 0 ) {
            $this->push_depot_positions($inStockDetails, $model);
        }
        $this->push_provider_positions($nonInStockDetails, $model);
        foreach ( $model->analogs as $analog ) {
            if ( $analog->in_stock > 0 ) {
                $this->push_depot_positions($inStockDetails, $analog);
            }
            $this->push_provider_positions($nonInStockDetails, $analog);
        }


        $inStockDetailsData = new CArrayDataProvider($inStockDetails, array(
            'pagination'=>array('pageSize'=>10000),
        ));
        $nonInStockDetailsData = new CArrayDataProvider($nonInStockDetails, array(
            'pagination'=>array('pageSize'=>10000),
        ));

        $assetsPath = $this->getAssetsUrl();
        Yii::app()->clientScript->registerCssFile( $assetsPath.'/css/catalog.css' );
        Yii::app()->clientScript->registerScriptFile( $assetsPath.'/js/vendor/jquery-scrolltofixed-ext.js', CClientScript::POS_END );
        Yii::app()->clientScript->registerScriptFile( $assetsPath.'/js/catalog.js', CClientScript::POS_END );
		$this->render('view',array(
            'findedDetail'=>$model,
            'autoModel'=>$autoModel,
            'engineModel'=>$engineModel,
			'inStockDetailsData'=>$inStockDetailsData,
            'nonInStockDetailsData'=>$nonInStockDetailsData,
		));
	}

    protected function push_depot_positions(&$stockArray, Details $model)
    {
        foreach ( $model->depotPositions as $depotPosition ) {
            if ( $depotPosition->stock == 0 )
                continue;
            $position = $model->duplicate();
            $position->in_stock = $depotPosition->stock;
            $position->price = $depotPosition->price;
            $position->delivery_time = 0;
            $position->virtualType = Details::VIRTUALTYPE_DEPOT;
            $position->virtualId = $depotPosition->depot_id;
            $stockArray[] = $position;
        }
    }

    protected function push_provider_positions(&$stockArray, Details $model)
    {
        foreach ( $model->providerPositions as $providerPosition ) {
            if ( $providerPosition->stock == 0 )
                continue;
            $position = $model->duplicate();
            $position->in_stock = $providerPosition->stock;
            $position->price = $providerPosition->price;
            $position->delivery_time = $providerPosition->delivery_time;
            $position->virtualType = Details::VIRTUALTYPE_PROVIDER;
            $position->virtualId = $providerPosition->provider_id;
            $stockArray[] = $position;
        }
    }
}
