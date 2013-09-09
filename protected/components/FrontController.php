<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class FrontController extends Controller
{
    public $layout='//layouts/main';
    public $menu=array();
    public $breadcrumbs=array();
    public $brand;


    public function init() {
        parent::init();

        // Выбор нового бренда
        if ( isset($_GET['set_brand']) ) {
            $brand = Brands::model()->findByAttributes(array('alias'=>$_GET['set_brand']));
            if ( $brand !== null ) {
                $brandState['id'] = $brand->id;
                $brandState['logo'] = $brand->getImageUrl('mini');
                $brandState['name'] = $brand->name;
                $brandState['alias'] = $brand->alias;
                $cookie = new CHttpCookie('CURRENT_BRAND', CJSON::encode($brandState));
                Yii::app()->request->cookies['CURRENT_BRAND'] = $cookie;
                $this->redirect('/site/index');
            }
        }
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
        $this->renderPartial('//layouts/clips/user_panel');
        return parent::beforeRender($view);
    }
}