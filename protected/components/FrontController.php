<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class FrontController extends Controller
{
    const COOKIE_VAR_CURRENT_BRAND = 'CURRENT_BRAND';

    public $layout='//layouts/main';
    public $menu=array();
    public $breadcrumbs=array();
    public $brand;


    public function init() {
        parent::init();

        // Определение текущего бренда
        $cookie = Yii::app()->request->cookies['CURRENT_BRAND'];
        if ( isset($cookie) ) {
            $this->brand = CJSON::decode($cookie->value);
        }

        $this->title = Yii::app()->name;
    }



    //Check home page
    public function is_home(){
        return $this->route == 'site/index';
    }

    public function beforeRender($view)
    {
        $this->renderPartial('//layouts/clips/head');
        $this->renderPartial('//layouts/clips/user_panel');
        $this->renderPartial('//layouts/clips/header');
        $this->renderPartial('//layouts/clips/footer');
        return parent::beforeRender($view);
    }
}
