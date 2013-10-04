<?php

class ConsumableController extends AdminController
{
    public function actions()
    {
        return array(
            'list' => array(
                'class'=>'ListAction',
                'modelName'=>'Details',
            ),
            'update' => array(
                'class'=>'UpdateAction',
                'modelName'=>'Details',
            ),
            'delete' => array(
                'class'=>'DeleteAction',
                'modelName'=>'Details',
            ),
            'restore' => array(
                'class'=>'RestoreAction',
                'modelName'=>'Details',
            ),
            'view' => array(
                'class'=>'ViewAction',
                'modelName'=>'Details',
            ),
            'sort' => array(
                'class'=>'SortAction',
                'modelName'=>'Details',
            ),
        );
    }

    public function actionCreate()
    {
        $model = new Details;
        $model->type = Details::TYPE_CONSUMABLE;

        if(isset($_POST['Details']))
        {
            $model->attributes = $_POST['Details'];
            $success = $model->save();
            if( $success ) {
                $this->redirect('/admin/consumable/list');
            }
        }

        $this->render('create', array('model' => $model));
    }
}
