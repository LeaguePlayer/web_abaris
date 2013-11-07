<?php

class DetailsController extends AdminController
{
    public function filters()
    {
        return CMap::mergeArray(parent::filters(), array(
            'ajaxOnly + adaptabillity',
        ));
    }

    public function beforeRender()
    {
        if ( !Yii::app()->request->isAjaxRequest ) {
            Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl('admin').'/js/details.js', CClientScript::POS_END);
            Yii::app()->clientScript->registerCssFile($this->getAssetsUrl('application').'/css/select2/select2.min.css');
            Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl('application').'/js/vendor/select2.min.js', CClientScript::POS_END);

        }
        return true;
    }

    public function actionCreate()
    {
        $model = new Details;
        $model->type = Details::TYPE_DETAIL;

        if(isset($_POST['Details']))
        {
            $model->attributes = $_POST['Details'];
            $success = $model->save();
            if( $success ) {
                $this->redirect('/admin/details/list');
            }
        }

        $this->render('create', array('model' => $model));
    }

    public function actionAdaptabilliti($detail_id)
    {
        $adaptabillity = new Adaptabillity();
        $adaptabillity->detail_id = $detail_id;
        if ( isset($_POST['Adaptabillity']) ) {
            if ( $_POST['Adaptabillity']['action'] == 'delete' && is_numeric($_POST['Adaptabillity']['auto_model_id']) ) {
                Adaptabillity::model()->deleteAllByAttributes(array(
                    'detail_id'=>$detail_id,
                    'auto_model_id'=>$_POST['Adaptabillity']['auto_model_id']
                ));
            } else {
                $adaptabillity->attributes = $_POST['Adaptabillity'];
                if ( !empty($adaptabillity->auto_model_id) && $adaptabillity->save() ) {
                    Yii::app()->user->setFlash('SUCCESS_ADAPTABILLITI', 'Сохранено!');
                }
            }
        }

        $detail = $this->loadModel('Details', $detail_id, array(
            'with' => 'adaptAutoModels',
        ));

        $criteria = new CDbCriteria();
        $criteria->select = 'id, name';
        $criteria->order = 'name';
        $criteria->addNotInCondition('id', CHtml::listData($detail->adaptAutoModels, 'id', 'id'));
        $autoModels = AutoModels::model()->findAll($criteria);

        $this->renderPartial('_adapt_modal', array(
            'detail'=>$detail,
            'adaptabilliti'=>$adaptabillity,
            'adaptModels'=>$detail->adaptAutoModels,
            'autoModels'=>$autoModels,
        ));
    }
}