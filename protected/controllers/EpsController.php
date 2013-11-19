<?php

class EpsController extends FrontController
{
    public $layout='//layouts/main';


    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }


    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view'),
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        switch ( $this->brand['alias'] ) {
            case 'ssang_yong':
                $epsUrl = "http://sy.ilcats.ru/pid/10584";
                break;
            case 'kia':
                $epsUrl = "http://kia.ilcats.ru/pid/10600";
                break;
            case 'hyundai':
                $epsUrl = "http://hyundai.ilcats.ru/pid/10602";
                break;
            case 'chevrolet':
                $epsUrl = 'http://app.autoxp.ru/pscomplex/catalog.aspx?clstep=catalog&mark=chevrolet&salerind=552';
                //$this->redirect('http://app.autoxp.ru/pscomplex/catalog.aspx?clstep=catalog&mark=chevrolet&salerind=552');
                break;
            case 'daewoo':
                $epsUrl = 'http://app.autoxp.ru/pscomplex/catalog.aspx?clstep=catalog&mark=daewoo&salerind=552';
                //$this->redirect('http://app.autoxp.ru/pscomplex/catalog.aspx?clstep=catalog&mark=daewoo&salerind=552');
                break;
            default:
                throw new CHttpException(404, 'Каталог не найден');

        }
        Yii::app()->clientScript->registerCssFile( $this->getAssetsUrl().'/css/eps.css' );
        $this->render('index', array('epsUrl'=>$epsUrl));
    }
}