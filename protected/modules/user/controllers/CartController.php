<?php
/**
 * Created by JetBrains PhpStorm.
 * User: megakuzmitch
 * Date: 19.09.13
 * Time: 9:20
 * To change this template use File | Settings | File Templates.
 */

class CartController extends FrontController
{
    public $defaultAction = 'index';
    public $layout = '//layouts/main';

    public function filterLoginControll($filterChain)
    {
        if ( Yii::app()->user->isGuest and Yii::app()->request->urlReferrer != $this->createAbsoluteUrl('/user/login') ) {
            Yii::app()->user->setReturnUrl($this->createUrl('/user/cart'));
            $this->redirect('/user/login');
        }

        $filterChain->run();
    }

    public function filters()
    {
        return array(
            'loginControll + index',
        );
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionPut($id)
    {
        $detail = Details::model()->findByPk($id);
        $response = array();
        if ( $detail === null ) {
            $response['error'] = 'Не найден товар';
        }

        Yii::app()->cart->put($detail);
        if ( Yii::app()->request->isAjaxRequest ) {
            $response['html'] = $this->renderPartial('success');
            echo CJSON::encode($response);
            Yii::app()->end();
        }
        $this->redirect(Yii::app()->request->urlReferrer);
    }
}