<?php

class CartController extends AdminController
{
    public function actionCreateOrder($cart_id)
    {
        $cart = Cart::model()->findByPk($cart_id);
        if ( !$cart ) {
            Yii::app()->user->setFlash('NO_CART_ERROR', 'Корзина не найдена');
        }

        $model = new Orders('admin');
        if ( $cart->user_id ) {
            $user = Yii::app()->db->createCommand()
                ->select('*')
                ->from('{{users}} u')
                ->join('{{profiles}} p', 'u.id=p.user_id')
                ->where('u.id=:id', array(':id'=>$cart->user_id))
                ->queryRow();
            if ( $user ) {
                $model->recipient_firstname = $user['first_name'];
                $model->recipient_family = $user['last_name'];
                $model->client_email = $user['email'];
                $model->client_phone = $user['phone'];
            }

        }
        $model->cart_id = $cart->id;

        if ( isset($_POST['Orders']) ) {
            $model->attributes = $_POST['Orders'];
            if ( $model->validate() ) {

            }
        }

        $this->render('order', array(
            'cart'=>$cart,
            'model'=>$model
        ));
    }
}