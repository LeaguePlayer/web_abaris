<?php
/**
 * Created by JetBrains PhpStorm.
 * User: megakuzmitch
 * Date: 02.10.13
 * Time: 15:09
 * To change this template use File | Settings | File Templates.
 */

class AbarisHtml extends CHtml
{
    public static function activeRadioButtonList($model,$attribute,$data,$htmlOptions=array())
    {
        self::resolveNameID($model,$attribute,$htmlOptions);
        $selection=self::resolveValue($model,$attribute);
        if($model->hasErrors($attribute))
            self::addErrorCss($htmlOptions);
        $name=$htmlOptions['name'];
        unset($htmlOptions['name']);

        return self::radioButtonList($name,$selection,$data,$htmlOptions);
    }

    public static function activeRadioButton($model,$attribute,$htmlOptions=array())
    {
        self::resolveNameID($model,$attribute,$htmlOptions);
        if(!isset($htmlOptions['value']))
            $htmlOptions['value']=1;
        if(!isset($htmlOptions['checked']) && self::resolveValue($model,$attribute)==$htmlOptions['value'])
            $htmlOptions['checked']='checked';
        self::clientChange('click',$htmlOptions);

        return self::activeInputField('radio',$model,$attribute,$htmlOptions);
    }

    public static function activeCheckBox($model,$attribute,$htmlOptions=array())
    {
        self::resolveNameID($model,$attribute,$htmlOptions);
        if(!isset($htmlOptions['value']))
            $htmlOptions['value']=1;
        if(!isset($htmlOptions['checked']) && self::resolveValue($model,$attribute)==$htmlOptions['value'])
            $htmlOptions['checked']='checked';
        self::clientChange('click',$htmlOptions);

        return self::activeInputField('checkbox',$model,$attribute,$htmlOptions);
    }
}