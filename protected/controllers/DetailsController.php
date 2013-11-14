<?php

class DetailsController extends FrontController
{
	public $layout='//layouts/main';

	
	public function actionView($id = false, $article = false, $brand = false)
	{
//        if ( $brand and $brand != $this->brand['alias'] ) {
//            $brandModel = Brands::model()->findByAttributes(array('alias'=>$brand));
//            if ( $brandModel !== null ) {
//                $brandState['id'] = $brandModel->id;
//                $brandState['logo'] = $brandModel->getImageUrl('icon');
//                $brandState['name'] = $brandModel->name;
//                $brandState['alias'] = $brandModel->alias;
//                $cookie = new CHttpCookie(self::COOKIE_VAR_CURRENT_BRAND, CJSON::encode($brandState));
//                Yii::app()->request->cookies[self::COOKIE_VAR_CURRENT_BRAND] = $cookie;
//                if ( $id ) {
//                    $url = $this->createUrl('/details/view', array('id'=>$id));
//                } else {
//                    $url = $this->createUrl('/details/view', array('article'=>$article));
//                }
//                $this->redirect($url);
//            }
//        }

        $autoModel = $this->loadModel('AutoModels', $_GET['model_id'], array('with'=>array('bodytype', 'engines')), false);
        if ( !empty($_GET['engine_id']) ) {
            foreach ( $this->engines as $engine) {
                if ( $engine->id === $_GET['engine_id'] ) {
                    $engineModel = $engine;
                    break;
                }
            }
        }

        $criteria = new CDbCriteria();
        $criteria->with = 'analogs';
        if ( $id ) {
            $criteria->compare('t.id', $id);
        } else if ( $article ) {
            $criteria->compare('t.article', $article);
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
        if ( $model->in_stock > 0 && $model->delivery_time == 0 ) {
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
