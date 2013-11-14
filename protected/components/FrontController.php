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
    public $pages;


    public function init() {
        parent::init();
        // Определение текущего бренда
        $cookie = Yii::app()->request->cookies['CURRENT_BRAND'];
        if ( isset($cookie) ) {
            $this->brand = CJSON::decode($cookie->value);
        }
        //print_r(Yii::app()->user->getState('__cartID')); die();
        $this->title = Yii::app()->name;
    }



    //Check home page
    public function is_home(){
        return $this->route == 'site/index';
    }

    public function beforeRender($view)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('status=:status');
        $criteria->params[':status'] = Pages::STATUS_PUBLISH;
        $criteria->order = 'section, sort';
        $pages = Pages::model()->findAll($criteria);
        foreach ( $pages as $page ) {
            $this->pages[$page->section][] = $page;
        }

        $this->renderPartial('//layouts/clips/head');
        $this->renderPartial('//layouts/clips/user_panel');
        $this->renderPartial('//layouts/clips/header');
        $this->renderPartial('//layouts/clips/footer');
        return parent::beforeRender($view);
    }

    public function beforeAction($action)
    {
        $getParams = $_GET;
        if ( isset($getParams['brand']) ) {
            if ( $getParams['brand'] != $this->brand['alias'] ) {
                $brandModel = Brands::model()->findByAttributes(array('alias'=>$getParams['brand']));
                if ( $brandModel === null )
                    throw new CHttpException(404, 'Страница не найдена');

                $brandState['id'] = $brandModel->id;
                $brandState['logo'] = $brandModel->getImageUrl('icon');
                $brandState['name'] = $brandModel->name;
                $brandState['alias'] = $brandModel->alias;
                $cookie = new CHttpCookie(self::COOKIE_VAR_CURRENT_BRAND, CJSON::encode($brandState));
                Yii::app()->request->cookies[self::COOKIE_VAR_CURRENT_BRAND] = $cookie;
                $this->brand = $brandState;
            }
        } else if ( $this->brand ) {
            switch ($this->route) {
                case 'site/index':
                case 'catalog/index':
                case 'catalog/engines':
                case 'catalog/details':
                case 'details/view':
                    $getParams['brand'] = $this->brand['alias'];
                    $this->redirect($this->createUrl($this->route, $getParams));
                    break;
            }

        }
        return parent::beforeAction($action);
    }
}
