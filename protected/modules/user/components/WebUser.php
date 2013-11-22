<?php
Yii::import('application.modules.auth.components.AuthWebUser');

class WebUser extends AuthWebUser
{

    /**
     * @var boolean whether to enable cookie-based login. Defaults to false.
     */
    public $allowAutoLogin=true;
    /**
     * @var string|array the URL for login. If using array, the first element should be
     * the route to the login action, and the rest name-value pairs are GET parameters
     * to construct the login URL (e.g. array('/site/login')). If this property is null,
     * a 403 HTTP exception will be raised instead.
     * @see CController::createUrl
     */
    public $loginUrl=array('/user/login');

    public function getRole()
    {
        return $this->getState('__role');
    }
    
    public function getId()
    {
        return $this->getState('__id') ? $this->getState('__id') : 0;
    }

//    protected function beforeLogin($id, $states, $fromCookie)
//    {
//        parent::beforeLogin($id, $states, $fromCookie);
//
//        $model = new UserLoginStats();
//        $model->attributes = array(
//            'user_id' => $id,
//            'ip' => ip2long(Yii::app()->request->getUserHostAddress())
//        );
//        $model->save();
//
//        return true;
//    }

    protected function afterLogin($fromCookie)
	{
        parent::afterLogin($fromCookie);
        $this->updateSession();

        // Слияние временной гостевой корзины и корзины пользователя
        // $userCart - корзина авторизованного пользователя
        $userCart = Cart::model()->with('cart_details')->findByAttributes(array('user_id'=>$this->id));

        if ( $userCart === null ) {
            $userCart = new Cart;
            $userCart->save(false);
        }

        // $userDetails - товары в корзине авторизованного пользователя
        $userDetails = new CTypedMap('CartDetails');
        foreach ( $userCart->cart_details as $userDetail ) {
            $userDetails->add($userDetail->detail_key, $userDetail);
        }

        $currentCart = Cart::model()->with('cart_details')->findByPk($this->getState('__cartID'));
        if ( $currentCart !== null ) {
            foreach ( $currentCart->cart_details as $currentDetail ) {
                if ( $userDetails->contains( $currentDetail->detail_key ) ) {
                    $uDetail = $userDetails->itemAt( $currentDetail->detail_key );
                    $uDetail->count = max($uDetail->count, $currentDetail->count);
                    $uDetail->status = $currentDetail->status;
                    $uDetail->save(false);
                    $currentDetail->delete();
                } else {
                    $currentDetail->cart_id = $userCart->id;
                    $currentDetail->save(false);
                    $userDetails->add($currentDetail->detail_key, $currentDetail);
                }
            }
            $currentCart->delete();
        }
        Yii::app()->cart->clear(false);
        foreach ( $userDetails as $uDetail ) {
            $position = $uDetail->detail;
            if ( $position !== null ) {
                $position->id = $uDetail->detail_key;
                Yii::app()->cart->update($position, $uDetail->count, false);
            }
            $position = null;
        }
        $this->setDbCart($userCart);
        $this->_cartDetails = null;
	}

    public function updateSession() {
        $user = Yii::app()->getModule('user')->user($this->id);
        $this->name = $user->username;
        $userAttributes = CMap::mergeArray(array(
                                                'email'=>$user->email,
                                                'username'=>$user->username,
                                                'SID'=>$user->SID,
                                                'create_at'=>$user->create_at,
                                                'lastvisit_at'=>$user->lastvisit_at,
                                           ),$user->profile->getAttributes());
        foreach ($userAttributes as $attrName=>$attrValue) {
            $this->setState($attrName,$attrValue);
        }
    }

    public function model($id=0) {
        return Yii::app()->getModule('user')->user($id);
    }

    public function user($id=0) {
        return $this->model($id);
    }

    public function getUserByName($username) {
        return Yii::app()->getModule('user')->getUserByName($username);
    }

    public function getAdmins() {
        return Yii::app()->getModule('user')->getAdmins();
    }

    public function isAdmin() {
        return Yii::app()->getModule('user')->isAdmin();
    }




    private $_cart;
    private $_cartDetails;

    public function getCartSID()
    {
        $cart = $this->getDbCart();
        return $cart->SID;
    }

    public function setDbCart(Cart $cart)
    {
        $this->_cart = $cart;
        $this->setState('__cartID', $cart->id);
        $this->_cartDetails = null;
    }

    public function getDbCart()
    {
        if ( $this->_cart === null ) {
            if ( !$this->isGuest ) {
                $cart = Cart::model()->with('cart_details')->findByAttributes(array('user_id'=>$this->id));
            } else if ( $this->hasState('__cartID') ) {
                $cart = Cart::model()->with('cart_details')->findByPk($this->getState('__cartID'));
            }

            if ( $cart === null ) {
                $cart = new Cart;
                $cart->save(false);
            }
            $this->setDbCart($cart);
        }
        return $this->_cart;
    }

    public function getCartDetails()
    {
        if ( $this->_cartDetails === null ) {
            $this->_cartDetails = new CTypedMap('CartDetails');
            $cart = $this->getDbCart();
            foreach ( $cart->cart_details as $detail ) {
                $this->_cartDetails->add($detail->detail_key, $detail);
            }
        }
        return $this->_cartDetails;
    }

    public function updateCartPosition($position)
    {
        $cartDetails = $this->getCartDetails();
        if ( $cartDetails->contains($position->getId()) ) {
            $detail = $cartDetails->itemAt( $position->getId() );
            $detail->count = $position->getQuantity();
            $detail->save(false);
        } else {
            $cart = $this->getDbCart();
            $detail = new CartDetails();
            $detail->cart_id = $cart->id;
            $detail->detail_id = $position->id;
            $detail->detail_key = $position->getCartKey();
            $detail->count = $position->getQuantity();
            if ( $detail->save(false) ) {
                $cartDetails->add($position->getId(), $detail);
            } else {
                Yii::app()->cart->remove($position->getId(), false);
            }
        }
    }

    public function removeCartPosition($key)
    {
        $cartDetails = $this->getCartDetails();
        if ( $cartDetails->contains($key) ) {
            $detail = $cartDetails->itemAt($key);
            if ( $detail->delete() )
                $cartDetails->remove($key);
        }
    }

    public function getDiscount()
    {
        $user = $this->model();
        return $user !== null ? $user->discount : 0;
    }

    public function getNewMessage()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $this->id);
        $criteria->compare('status', Messages::STATUS_NEW);
        $criteria->order = 'create_time';
        $message = Messages::model()->find($criteria);
        if ( $message === null ) {
            return null;
        }
        return $message->message;
    }
}