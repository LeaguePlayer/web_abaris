<?php
/**
 * Created by JetBrains PhpStorm.
 * User: megakuzmitch
 * Date: 10.09.13
 * Time: 17:09
 * To change this template use File | Settings | File Templates.
 */

class AutoModelsHystory extends Hystory
{
    protected $currentBrand;

    public function __construct($limit = 3, $brandId = 0) {
        parent::__construct($limit);
        $cookie = Yii::app()->request->cookies['__last_models'];
        if ( isset($cookie) ) {
            $this->stack = unserialize($cookie->value);
        }
        $this->currentBrand = $brandId;
    }

    public function push($element)
    {
        if ( !($element instanceof AutoModels) )
            return;

        $item = array(
            'id'=>$element->id,
            'brand'=>$element->brand->name,
            'has_photo'=>$element->hasImage(),
            'photo'=>$element->getImageUrl('small'),
            'name'=>$element->name,
            'bodytype'=>$element->bodytype->name,
            'release_range'=>$element->getReleaseRange(),
            'full_name'=>$element->getFullName(),
        );
        $this->stack[$this->currentBrand][] = $item;

        if (count($this->stack[$this->currentBrand]) > $this->limit) {
            array_shift($this->stack[$this->currentBrand]);
        }
        $cookie = new CHttpCookie('__last_models', serialize($this->stack));
        Yii::app()->request->cookies['__last_models'] = $cookie;
    }

    public function getLastElement()
    {
        return $this->stack[$this->currentBrand][ count($this->stack[$this->currentBrand]) - 1 ];
    }

    public function getAllElements()
    {
        return empty($this->stack[$this->currentBrand]) ? array() : $this->stack[$this->currentBrand];
    }

    public function clear()
    {
        $this->stack = array();
        Yii::app()->request->cookies['__last_models'] = new CHttpCookie('__last_models', serialize($this->stack));
    }
}