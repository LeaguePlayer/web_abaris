<?php
/**
 * Created by JetBrains PhpStorm.
 * User: megakuzmitch
 * Date: 29.08.13
 * Time: 13:33
 * To change this template use File | Settings | File Templates.
 */

class EWebModule extends CWebModule
{
    protected $forceCopyAssets = true;
    protected $assetsUrl;


    public function getAssetsUrl()
    {
        if ( !isset($this->assetsUrl) )
        {
            $assetsPath = Yii::getPathOfAlias($this->getName().'.assets');
            $this->assetsUrl = Yii::app()->assetManager->publish($assetsPath, false, -1, $this->forceCopyAssets);
        }
        return $this->assetsUrl;
    }


    public function preinit()
    {
        // Reset the front-end's client script because we don't want
        // both front-end styles being applied in this module.
        Yii::app()->clientScript->reset();
    }


    public function beforeControllerAction($controller, $action)
    {
        if ( parent::beforeControllerAction($controller, $action) ) {
            //$this->registerCoreScripts();
            return true;
        }
        return false;
    }

    public function registerBootstrap()
    {

        $this->setAliases(array(
            'bootstrap'=>'appext.yiistrap',
            'yiiwheels'=>'appext.yiiwheels',
        ));
        $this->setImport(array(
            'bootstrap.helpers.*'
        ));
        $this->setComponents(array(
            'widgetFactory'=>array(
                'widgets'=>array(
                    'WhDatePicker'=>array(
                        'pluginOptions' => array(
                            'format' => 'mm.dd.yyyy',
                            'language' => 'ru'
                        )
                    ),
                ),
            ),
        ));

        Yii::app()->getComponent('bootstrap')->register();
    }

    public function registerFancybox(Controller $controller)
    {
        $assetsPath = $controller->getAssetsUrl('application');
        Yii::app()->clientScript->registerCssFile($assetsPath.'/css/fancybox/jquery.fancybox.css');
        Yii::app()->clientScript->registerScriptFile($assetsPath.'/js/vendor/fancybox/jquery.fancybox.pack.js', CClientScript::POS_END);
    }

    protected function registerCoreScripts()
    {
        Yii::app()->clientScript->registerCoreScript('jquery');
    }
}