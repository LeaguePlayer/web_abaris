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
        if ( isset($_POST['CartItems']) and !empty($_POST['CartItems']['checked']) ) {
            switch ( $_POST['CartItems']['action'] ) {
                case 'delete':
                    $this->deleteCartItems($_POST['CartItems']);
                    break;
                case 'archive':
                    $this->archiveCartItems($_POST['CartItems']);
                    break;
                case 'active':
                    $this->activeCartItems($_POST['CartItems']);
                    break;
            }
        }


        $user = Yii::app()->user->model();
        $userDiscount = $user !== null ? $user->discount : 0;

        $activedPositions = array();
        $archivedPositions = array();
        foreach ( Yii::app()->cart->getPositions() as $position ) {
            if ( $position->cartInfo->status == CartDetails::STATUS_ARCHIVED )
                $archivedPositions[] = $position;
            else
                $activedPositions[] = $position;
        }

        $cartDataProvider = new CArrayDataProvider(CMap::mergeArray($activedPositions, $archivedPositions), array(
            'pagination'=>false,
        ));

        $cs = Yii::app()->clientScript;
        $assetsPath = $this->getAssetsUrl('application');
        $cs->registerCssFile($assetsPath.'/css/spinner.css');
        $cs->registerCssFile($assetsPath.'/css/catalog.css');
        $cs->registerCssFile($assetsPath.'/css/cart.css');
        $cs->registerScriptFile($assetsPath.'/js/vendor/jquery-scrolltofixed-ext.js', CClientScript::POS_END);
        $cs->registerCoreScript('jquery.ui');
        $cs->registerScriptFile($assetsPath.'/js/cart.js', CClientScript::POS_END);
        $this->render('index', array(
            'cartDataProvider'=>$cartDataProvider,
            'userDiscount'=>$userDiscount,
        ));
    }



    public function actionPut($id)
    {
        $position = Details::model()->findByPk($id);
        $response = array();
        if ( $position === null ) {
            $response['error'] = 'Не найден товар';
        }

        Yii::app()->cart->put($position);
        if ( Yii::app()->request->isAjaxRequest ) {
            $response['html'] = $this->renderPartial('success');
            echo CJSON::encode($response);
            Yii::app()->end();
        }

        if ( !empty(Yii::app()->request->urlReferrer) and Yii::app()->request->urlReferrer != $this->createAbsoluteUrl('/user/cart/put', array('id'=>$id)) )
            $this->redirect(Yii::app()->request->urlReferrer);
        else
            $this->redirect('/user/cart');
    }



    public function actionUpdate($id)
    {
        $cart = Yii::app()->cart;
        if ( $cart->contains($id) ) {
            $position = $cart->itemAt($id);
        } else {
            $position = Details::model()->findByPk($id);
            if ( $position === null ) {
                $response['error'] = 'Не найден товар';
            }
        }
        $cart->update($position);
        if ( Yii::app()->request->isAjaxRequest ) {
            $response['html'] = $this->renderPartial('success');
            $response['count'] = $position->getQuantity();
            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }








    protected function deleteCartItems($postItems)
    {
        $cart = Yii::app()->cart;
        foreach ( $postItems['checked'] as $positionId )
        {
            $cart->remove($positionId);
        }
    }

    protected function archiveCartItems($postItems)
    {
        $cart = Yii::app()->cart;
        foreach ( $postItems['checked'] as $positionId )
        {
            $position = $cart->itemAt($positionId);
            if ( !$position or $position->cartInfo->status == CartDetails::STATUS_ARCHIVED )
                continue;
            $detailInfo = $position->cartInfo;
            $detailInfo->status = CartDetails::STATUS_ARCHIVED;
            $detailInfo->save(false);
        }
    }

    protected function activeCartItems($postItems)
    {
        $cart = Yii::app()->cart;
        foreach ( $postItems['checked'] as $positionId )
        {
            $position = $cart->itemAt($positionId);
            if ( !$position or $position->cartInfo->status == CartDetails::STATUS_ACTIVE )
                continue;
            $detailInfo = $position->cartInfo;
            $detailInfo->status = CartDetails::STATUS_ACTIVE;
            $detailInfo->save(false);
        }
    }
}