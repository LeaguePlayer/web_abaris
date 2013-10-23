<?php
/**
 * Created by JetBrains PhpStorm.
 * User: megakuzmitch
 * Date: 21.10.13
 * Time: 14:54
 * To change this template use File | Settings | File Templates.
 */

class SiteSearch extends CWidget
{
    public function run()
    {
        $form = new SiteSearchForm();
        $this->render('form', array('form'=>$form));
    }
}