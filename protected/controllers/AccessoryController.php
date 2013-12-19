<?php

class AccessoryController extends FrontCatalogController
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
                'actions'=>array('index','view','engines','details'),
                'users'=>array('*'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }


    public function actionIndex($chooseLetter = false)
    {
        $criteria = new CDbCriteria();
        if ( $this->brand !== null ) {
            $criteria->addCondition('brand_id=:brand_id');
            $criteria->params[':brand_id'] = $this->brand['id'];
            $criteria->params[':brand_id'] = $this->brand['id'];
        }
        $firstLetters = array();
        foreach ( range('A', 'Z') as $letter ) {
            $firstLetters[strtolower($letter)] = $letter;
        }
        if ( $chooseLetter ) {
            $criteria->addCondition("name LIKE :letter");
            $criteria->params[':letter'] =  $chooseLetter.'%';
        }
        $criteria->order = 'dt_release_date';
        $autoModels = AutoModels::model()->findAll($criteria);
        $hystory = new AutoModelsHystory(3, $this->brand['id']);

        $renderMethod = Yii::app()->request->isAjaxRequest ? 'renderPartial' : 'render';

        Yii::app()->clientScript->registerCssFile( $this->getAssetsUrl().'/css/auto-catalog.css' );
        Yii::app()->clientScript->registerScriptFile( $this->getAssetsUrl().'/js/auto-catalog.js', CClientScript::POS_END );
        $this->{$renderMethod}('index', array(
            'lastModels'=>$hystory->getAllElements(),
            'autoModels'=>$autoModels,
            'firstLetters'=>$firstLetters,
            'currentFirstLetter'=>$chooseLetter,
        ));
    }


    public function actionEngines($model_id)
    {
        // Получаем выбранную марку авто
        $criteria = new CDbCriteria();
        $criteria->with = array('engines');
        $criteria->compare('t.id', $model_id);

        $autoModel = AutoModels::model()->find($criteria);
        if ( $autoModel === null ) {
            throw new CHttpException(404, 'Страница не найдена');
        }

        $engines = $autoModel->engines;
        if ( empty($engines) ) {
            $this->redirect(array('details', 'model_id'=>$autoModel->id));
        }

        $enginesDataProvider = new CArrayDataProvider($engines);

        $assetsPath = $this->getAssetsUrl();
        Yii::app()->clientScript->registerCssFile( $assetsPath.'/css/catalog.css' );
        Yii::app()->clientScript->registerCssFile( $assetsPath.'/css/engine.css' );
        Yii::app()->clientScript->registerScriptFile( $assetsPath.'/js/vendor/jquery-scrolltofixed-ext.js', CClientScript::POS_END );
        Yii::app()->clientScript->registerScriptFile( $assetsPath.'/js/catalog.js', CClientScript::POS_END );
        $this->render('engines',array(
            'autoModel'=>$autoModel,
            'enginesDataProvider'=>$enginesDataProvider,
        ));
    }


    public function actionDetails($model_id = false, $engine_id = false)
    {
        // Получаем выбранную марку авто и модель двигателя
        if ( $model_id )
            $autoModel = $this->loadModel('AutoModels', $model_id);
        if ( $engine_id ) {
            if ( $autoModel ) {
                foreach ( $autoModel->engines as $engine) {
                    if ( $engine->id === $engine_id ) {
                        $engineModel = $engine;
                        break;
                    }
                }
            } else {
                $engineModel = Engines::model()->findByPk($engine_id);
            }
        }

        // Сохраняем в истории просмотра
        if ( $autoModel ) {
            if ( !Yii::app()->request->isAjaxRequest ) {
                $hystory = new AutoModelsHystory(3, $this->brand['id']);
                $lastAutoModels = $hystory->getAllElements();
                $exist = false;
                foreach ( $lastAutoModels as $item ) {
                    if ( $item['id'] == $autoModel->id ) {
                        $exist = true;
                        break;
                    }
                }
                if ( !$exist )
                    $hystory->push($autoModel);
            }
        }

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
        $criteria->params[':cat_name'] = 'Аксессуары';
        if ( $engine_id ) {
            $sqlCond = 't.id IN (SELECT DISTINCT detail_id FROM '.Adaptabillity::model()->tableName().' WHERE engine_model_id=:engine_id)';
            $criteria->params[':engine_id'] = $engine_id;
        } else if ( $model_id ) {
            $sqlCond = 't.id IN (SELECT DISTINCT detail_id FROM '.Adaptabillity::model()->tableName().' WHERE auto_model_id=:model_id)';
            $criteria->params[':model_id'] = $model_id;
        }

        if ( $sqlCond ) {
            $criteria->addCondition($sqlCond);
        }
        $dataProvider=new CActiveDataProvider('Details', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>100,
            ),
        ));

        if ( Yii::app()->request->isAjaxRequest ) {
            $this->renderPartial('details', array(
                'finder'=>$finder,
                'autoModel'=>$autoModel,
                'engineModel'=>$engineModel,
                'dataProvider'=>$dataProvider,
            ));
            Yii::app()->end();
        }

        $assetsPath = $this->getAssetsUrl();
        Yii::app()->clientScript->registerCssFile( $assetsPath.'/css/catalog.css' );
        Yii::app()->clientScript->registerScriptFile( $assetsPath.'/js/vendor/jquery-scrolltofixed-ext.js', CClientScript::POS_END );
        Yii::app()->clientScript->registerScriptFile( $assetsPath.'/js/vendor/jquery.scrollTo.js', CClientScript::POS_END );
        Yii::app()->clientScript->registerScriptFile( $assetsPath.'/js/catalog.js', CClientScript::POS_END );
        $this->render('details',array(
            'finder'=>$finder,
            'autoModel'=>$autoModel,
            'engineModel'=>$engineModel,
            'dataProvider'=>$dataProvider,
        ));
    }


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
            $this->render( 'nofounddetail', array('detailNotFound'=>$detailNotFound) );
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
}
