<?php
/**
 * Created by JetBrains PhpStorm.
 * User: megakuzmitch
 * Date: 10.09.13
 * Time: 11:32
 * To change this template use File | Settings | File Templates.
 */

class CatalogController extends FrontController
{
    public $layout = '//layouts/main';

    public function actionIndex()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('status='.AutoModels::STATUS_PUBLISH);
        if ( $this->brand !== null ) {
            $criteria->addCondition('brand_id=:brand_id');
            $criteria->params[':brand_id'] = $this->brand['id'];
        }
        $criteria->order = 'dt_release_date';
        $autoModels = AutoModels::model()->findAll($criteria);
        $hystory = new AutoModelsHystory(3, $this->brand['id']);

        Yii::app()->clientScript->registerCssFile( $this->getAssetsUrl().'/css/auto-catalog.css' );
        $this->render('index', array(
            'lastModels'=>$hystory->getAllElements(),
            'autoModels'=>$autoModels,
        ));
    }


    public function actionDetails($model_id, $engine_id = false)
    {
        // Получаем выбранную марку авто и модель двигателя
        $autoModel = $this->loadModel('AutoModels', $model_id);
        if ( $engine_id ) {
            foreach ( $autoModel->engines as $engine) {
                if ( $engine->id === $engine_id ) {
                    $engineModel = $engine;
                    break;
                }
            }
            if ( !$engineModel and $engine_id === $autoModel->engine->id ) {
                $engineModel = $autoModel->engine;
            }
        } else {
            $engineModel = $autoModel->engine;
        }

        // Сохраняем в истории просмотра
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

        // Получаем списки категорий
        $criteriaCat = new CDbCriteria;
        $criteriaCat->with = 'childs';
        $criteriaCat->compare('t.level', 0);
        $criteriaCat->order = 't.name';
        $categories = DetailCategory::model()->findAll($criteriaCat);


        // Установка текущей категории
        if ( isset($_GET['cat']) ) {
            foreach ( $categories as $cat ) {
                if ( $cat->id == $_GET['cat'] ) {
                    $currentCategory = $cat;
                    $currentSubCategory = new DetailCategory('search');
                    $childCategories = $currentCategory->childs;
                    break;
                }
            }
            if ( !isset($currentCategory) ) {
                if ( $_GET['prevRootCat'] != 0 ) {
                    foreach ( $categories as $cat ) {
                        if ( $cat->id == $_GET['prevRootCat'] ) {
                            $currentCategory = $cat;
                            $childCategories = $currentCategory->childs;
                            break;
                        }
                    }
                } else {
                    $childCategories = DetailCategory::model()->findAll(array('condition'=>'level=1', 'order'=>'name'));
                }
                foreach ( $childCategories as $subCat ) {
                    if ( $subCat->id == $_GET['cat'] ) {
                        $currentSubCategory = $subCat;
                        $currentCategory = $currentSubCategory->parent;
                        $childCategories = $currentCategory->childs;
                        break;
                    }
                }
            }
        }

        if ( !isset($currentCategory) ) {
            $currentCategory = new DetailCategory('search');
        }
        if ( !isset($currentSubCategory) ) {
            $currentSubCategory = new DetailCategory('search');
        }
        if ( !isset($childCategories) ) {
            $childCategories = DetailCategory::model()->findAll(array('condition'=>'level=1', 'order'=>'name'));
        }

        $detailFinder = new Details('search');
        $detailFinder->unsetAttributes();
        if ( isset($_GET['Details']) ) {
            $detailFinder->attributes = $_GET['Details'];
        }

        // Вытаскиваем детали для выбранной модели авто с учетом текущей категории и фильтра, а также типом движка
        $criteriaDet = new CDbCriteria();
        if ( $currentCategory->isNewRecord ) {
            $categoriesList = CMap::mergeArray( CHtml::listData($categories, 'id', 'id'), CHtml::listData($childCategories, 'id', 'id') );
        } else if ( $currentSubCategory->isNewRecord ) {
            $categoriesList = CMap::mergeArray( array($currentCategory->id), CHtml::listData($childCategories, 'id', 'id') );
        } else {
            $categoriesList = array($currentCategory->id, $currentSubCategory->id);
        }
        $criteriaDet->compare('name', $detailFinder->name, true);
        $criteriaDet->compare('article', $detailFinder->article, true);
        $criteriaDet->addInCondition('category_id', $categoriesList);
        $sqlCond = 'id IN (SELECT DISTINCT detail_id FROM '.Adaptabillity::model()->tableName().' WHERE auto_model_id=:model_id';
        $criteriaDet->params[':model_id'] = $model_id;
        if ( $engine_id ) {
            $sqlCond .= ' OR engine_model_id=:engine_id)';
            $criteriaDet->params[':engine_id'] = $engine_id;
        } else {
            $sqlCond .= ')';
        }
        $criteriaDet->addCondition($sqlCond);
        $detailsData = new CActiveDataProvider('Details', array(
            'criteria'=>$criteriaDet,
            'pagination'=>array(
                'pageSize'=>20
            )
        ));

        $renderMethod = Yii::app()->request->isAjaxRequest ? 'renderPartial' : 'render';

        Yii::app()->clientScript->registerCssFile( $this->getAssetsUrl().'/css/catalog.css' );
        Yii::app()->clientScript->registerCssFile( $this->getAssetsUrl().'/css/engine.css' );
        Yii::app()->clientScript->registerScriptFile( $this->getAssetsUrl().'/js/catalog.js', CClientScript::POS_END );
        $this->{$renderMethod}('details', array(
            'autoModel'=>$autoModel,
            'engineModel'=>$engineModel,
            'categories'=>$categories,
            'childCategories'=>$childCategories,
            'currentCategory'=>$currentCategory,
            'currentSubCategory'=>$currentSubCategory,
            'detailsData'=>$detailsData,
            'detailFinder'=>$detailFinder,
        ));
    }


    public function actionEngines($model_id)
    {
        // Получаем выбранную марку авто
        $autoModel = $this->loadModel('AutoModels', $model_id, array(
            'with'=>array('engines', 'engine'),
        ));
        $engines = !empty($autoModel->engines) ? $autoModel->engines :
            !empty($autoModel->engine) ? array($autoModel->engine) : array();
        $enginesDataProvider = new CArrayDataProvider($engines);

        Yii::app()->clientScript->registerCssFile( $this->getAssetsUrl().'/css/catalog.css' );
        Yii::app()->clientScript->registerCssFile( $this->getAssetsUrl().'/css/engine.css' );
        Yii::app()->clientScript->registerScriptFile( $this->getAssetsUrl().'/js/catalog.js', CClientScript::POS_END );
        $this->render('engines',array(
            'autoModel'=>$autoModel,
            'enginesDataProvider'=>$enginesDataProvider,
        ));
    }
}