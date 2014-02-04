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
        $urlReferrer = Yii::app()->request->urlReferrer;
        if ( Yii::app()->user->isGuest and $urlReferrer != $this->createAbsoluteUrl('/user/login') and $urlReferrer != $this->createAbsoluteUrl('/user/cart') ) {
            Yii::app()->user->setReturnUrl($this->createUrl('/user/cart'));
            $this->redirect('/user/login');
        }
        $filterChain->run();
    }


    public function filters()
    {
        return array(
            'loginControll + index',
            'ajaxOnly + update, setSelfTransport',
            'postOnly + setSelfTransport',
        );
    }


    public function actionIndex()
    {
        $cart = Yii::app()->user->getDbCart();

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

        if ( Yii::app()->request->isAjaxRequest ) {
            $this->renderPartial('index', array(
                'cartDataProvider'=>$cartDataProvider,
                'userDiscount'=>$userDiscount,
                'cart' => $cart,
            ));
            Yii::app()->end();
        }

        $cs = Yii::app()->clientScript;
        $assetsPath = $this->getAssetsUrl('application');
        $cs->registerCssFile($assetsPath.'/css/spinner.css');
        $cs->registerCssFile($assetsPath.'/css/catalog.css');
        $cs->registerCssFile($assetsPath.'/css/cart.css', '', 100);
        $cs->registerCoreScript('jquery.ui');
        $cs->registerScriptFile($assetsPath.'/js/vendor/jquery-scrolltofixed-ext.js', CClientScript::POS_END);
        $cs->registerScriptFile($assetsPath.'/js/vendor/accounting.js', CClientScript::POS_END);
        $cs->registerScriptFile($assetsPath.'/js/cart.js', CClientScript::POS_END);
        $this->render('index', array(
            'cartDataProvider'=>$cartDataProvider,
            'userDiscount'=>$userDiscount,
            'cart' => $cart,
        ));
    }



    public function actionPut($key)
    {
        $cart = Yii::app()->cart;
        if ( $cart->contains($key) ) {
            $position = Yii::app()->cart->itemAt($key);
            $position->unarchivate();
        } else {
            $keyParts = explode('_', $key);
            $posId = $keyParts[0];
            $position = Details::model()->findByPk($posId);
            if ( $position === null ) {
                throw new CHttpException(404, 'Не найден товар');
                Yii::app()->end();
            }
            $position->setCartKey($key);
            $cart->put($position);
        }

        if ( Yii::app()->request->isAjaxRequest ) {
            echo $this->renderPartial('success');
            Yii::app()->end();
        }

        if ( !empty(Yii::app()->request->urlReferrer) and Yii::app()->request->urlReferrer != $this->createAbsoluteUrl('/user/cart/put', array('id'=>$id)) )
            $this->redirect(Yii::app()->request->urlReferrer);
        else
            $this->redirect('/user/cart');
    }



    public function actionUpdate($key, $count)
    {
        $cart = Yii::app()->cart;
        if ( $cart->contains($key) ) {
            $position = $cart->itemAt($key);
        } else {
            $parts = explode('_', $key);
            $posId = $parts[0];
            $position = Details::model()->findByPk($posId);
            if ( $position === null ) {
                throw new CHttpException(404, 'Не найдена деталь');
            }
            $position->setCartKey($key);
        }
        $cart->update($position, $count);
        $cost = $cart->getCost();
        $dbCart = Yii::app()->user->getDbCart();

        $response = array(
            'count' => $position->getQuantity(),
            'self_transport' => $dbCart->self_transport,
            'delivery_price' => $dbCart->getDeliveryPrice($cost)
        );
        echo CJSON::encode($response);
    }




    protected function deleteCartItems($postItems)
    {
        $cart = Yii::app()->cart;
        foreach ( $postItems['checked'] as $positionKey )
        {
            $cart->remove($positionKey);
        }
    }

    protected function archiveCartItems($postItems)
    {
        $cart = Yii::app()->cart;
        foreach ( $postItems['checked'] as $positionKey )
        {
            $position = $cart->itemAt($positionKey);
            $cartInfo = $position->getCartInfo();
            if ( !$position or $cartInfo->status == CartDetails::STATUS_ARCHIVED )
                continue;
            $cartInfo->status = CartDetails::STATUS_ARCHIVED;
            $cartInfo->save(false);
        }
    }

    protected function activeCartItems($postItems)
    {
        $cart = Yii::app()->cart;
        foreach ( $postItems['checked'] as $positionKey )
        {
            $position = $cart->itemAt($positionKey);
            $cartInfo = $position->getCartInfo();
            if ( !$position or $cartInfo->status == CartDetails::STATUS_ACTIVE )
                continue;
            $cartInfo->status = CartDetails::STATUS_ACTIVE;
            $cartInfo->save(false);
        }
    }

    public function actionRemindSto()
    {
        if ( Yii::app()->request->isAjaxRequest ) {
            $this->renderPartial('_remind_sto');
            Yii::app()->end();
        }

        $this->render('_remind_sto');
    }

    public function actionSetSelfTransport()
    {
        if ( isset( $_POST['Cart'] ) ) {
            $cart = Yii::app()->user->getDbCart();
            $cart->self_transport = $_POST['Cart']['self_transport'];
            $cartCost = Yii::app()->cart->getCost();
            if ( $cart->save() ) {
                echo CJSON::encode(array(
                    'success' => true,
                    'self_transport' => $cart->self_transport,
                    'cart_cost' => $cartCost,
                    'delivery_price' => $cart->getDeliveryPrice( $cartCost ),
                ));
                Yii::app()->end();
            }
        }
        echo CJSON::encode(array(
            'success' => false
        ));
    }
}