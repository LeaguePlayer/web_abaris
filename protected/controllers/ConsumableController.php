<?php

class ConsumableController extends FrontController
{
	public $layout='//layouts/main';

	
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	
	public function actionView($id = false, $article = false)
	{
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
        } else {
            throw new CHttpException(404, 'Товар с таким артикулом не найден');
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
        foreach ( $model->analogs as $analog ) {
            if ( $analog->in_stock > 0 ) {
                $inStockDetails[] = $analog;
            } else {
                $nonInStockDetails[] = $analog;
            }
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
            'inStockDetailsData'=>$inStockDetailsData,
            'nonInStockDetailsData'=>$nonInStockDetailsData,
        ));
	}

	
	public function actionIndex()
	{
        $finder = new Details('search');
        $finder->unsetAttributes();
        if ( isset($_GET['Details']) ) {
            $finder->attributes = $_GET['Details'];
        }
        $criteria = new CDbCriteria();
        $criteria->compare('t.name', $finder->name, true);
        $criteria->compare('article_alias', $finder->article, true);
        $criteria->order = 't.name';
        $criteria->with = 'category';
        $criteria->addCondition('category.name=:cat_name');
        $criteria->params[':cat_name'] = 'Расходники';
        $dataProvider=new CActiveDataProvider('Details', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>100,
            ),
        ));

        if ( Yii::app()->request->isAjaxRequest ) {
            $this->renderPartial('index', array(
                'finder'=>$finder,
                'dataProvider'=>$dataProvider,
            ));
            Yii::app()->end();
        }

        $assetsPath = $this->getAssetsUrl();
        Yii::app()->clientScript->registerCssFile( $assetsPath.'/css/catalog.css' );
        Yii::app()->clientScript->registerScriptFile( $assetsPath.'/js/vendor/jquery-scrolltofixed-ext.js', CClientScript::POS_END );
        Yii::app()->clientScript->registerScriptFile( $assetsPath.'/js/vendor/jquery.scrollTo.js', CClientScript::POS_END );
        Yii::app()->clientScript->registerScriptFile( $assetsPath.'/js/catalog.js', CClientScript::POS_END );
        $this->render('index',array(
            'finder'=>$finder,
            'dataProvider'=>$dataProvider,
        ));
	}
}
