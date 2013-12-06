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


    public function actionDetails($model_id = false, $engine_id = false, $article = false)
    {
        if ( !$model_id && !$engine_id && !$article )
            throw new CHttpException(403, 'Некорректный запрос');

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
        $detailFinder->type = Details::TYPE_DETAIL;
        if ( isset($_GET['Details']) ) {
            $detailFinder->attributes = $_GET['Details'];
        }

        // Вытаскиваем детали для выбранной модели авто с учетом текущей категории и фильтра, а также типом движка
        $criteriaDet = new CDbCriteria();
        $criteriaDet->order = 'name';
        $criteriaDet->compare('type', Details::TYPE_DETAIL);
        $criteriaDet->compare('name', $detailFinder->name, true);
        if ( $article && !isset($_GET['Details']['article']) )
            $detailFinder->article = $article;
        $criteriaDet->compare('article_alias', $detailFinder->article, true);
        if ( !$article )
            $criteriaDet->compare('is_original', 1);
        if ( $currentCategory->isNewRecord ) {
            $categoriesList = CMap::mergeArray( CHtml::listData($categories, 'id', 'id'), CHtml::listData($childCategories, 'id', 'id') );
        } else if ( $currentSubCategory->isNewRecord ) {
            $categoriesList = CMap::mergeArray( array($currentCategory->id), CHtml::listData($childCategories, 'id', 'id') );
        } else {
            $categoriesList = array($currentCategory->id, $currentSubCategory->id);
        }
        $criteriaDet->addInCondition('category_id', $categoriesList);
        if ( $model_id ) {
            $sqlCond = 'id IN (SELECT DISTINCT detail_id FROM '.Adaptabillity::model()->tableName().' WHERE auto_model_id=:model_id';
            $criteriaDet->params[':model_id'] = $model_id;
            if ( $engine_id ) {
                $sqlCond .= ' OR engine_model_id=:engine_id)';
                $criteriaDet->params[':engine_id'] = $engine_id;
            } else {
                $sqlCond .= ')';
            }
        } else if ( $engine_id ) {
            $sqlCond = 'id IN (SELECT DISTINCT detail_id FROM '.Adaptabillity::model()->tableName().' WHERE engine_model_id=:engine_id)';
            $criteriaDet->params[':engine_id'] = $engine_id;
        }
        if ( $sqlCond ) {
            $criteriaDet->addCondition($sqlCond);
        }

        $detailsData = new CActiveDataProvider('Details', array(
            'criteria'=>$criteriaDet,
            'pagination'=>array(
                'pageSize'=>50
            )
        ));

        if ( Yii::app()->request->isAjaxRequest ) {
            $this->renderPartial('details', array(
                'autoModel'=>$autoModel,
                'engineModel'=>$engineModel,
                'categories'=>$categories,
                'childCategories'=>$childCategories,
                'currentCategory'=>$currentCategory,
                'currentSubCategory'=>$currentSubCategory,
                'detailsData'=>$detailsData,
                'detailFinder'=>$detailFinder,
            ));
            Yii::app()->end();
        }

        $assetsPath = $this->getAssetsUrl();
        Yii::app()->clientScript->registerCssFile( $assetsPath.'/css/catalog.css' );
        Yii::app()->clientScript->registerCssFile( $assetsPath.'/css/engine.css' );
        Yii::app()->clientScript->registerScriptFile( $assetsPath.'/js/vendor/jquery-scrolltofixed-ext.js', CClientScript::POS_END );
        Yii::app()->clientScript->registerScriptFile( $assetsPath.'/js/vendor/jquery.scrollTo.js', CClientScript::POS_END );
        Yii::app()->clientScript->registerScriptFile( $assetsPath.'/js/catalog.js', CClientScript::POS_END );
        $this->render('details', array(
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
}