<?php
/**
 * Created by JetBrains PhpStorm.
 * User: megakuzmitch
 * Date: 12.09.13
 * Time: 17:57
 * To change this template use File | Settings | File Templates.
 */

class ELinkPager extends CLinkPager
{
    /**
     * Creates a page button.
     * You may override this method to customize the page buttons.
     * @param string $label the text label for the button
     * @param integer $page the page number
     * @param string $class the CSS class for the page button.
     * @param boolean $hidden whether this page button is visible
     * @param boolean $selected whether this page button is selected
     * @return string the generated button
     */
    protected function createPageButton($label,$page,$class,$hidden,$selected)
    {
        if ($selected)
            return '<li class="'.$class.$this->selectedPageCssClass.'">'.$label.'</li>';
        if($hidden)
            $class.=' '.$this->hiddenPageCssClass;
        return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page)).'</li>';
    }
}
