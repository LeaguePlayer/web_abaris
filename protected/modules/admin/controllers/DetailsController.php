<?php

class DetailsController extends AdminController
{
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
}