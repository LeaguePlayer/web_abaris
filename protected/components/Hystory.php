<?php
/**
 * Created by JetBrains PhpStorm.
 * User: megakuzmitch
 * Date: 10.09.13
 * Time: 17:06
 * To change this template use File | Settings | File Templates.
 */

abstract class Hystory extends CComponent
{
    protected $stack;
    protected $limit;

    public function __construct($limit = 3) {
        $this->stack = array();
        $this->limit = $limit;
    }

    abstract public function push($element);
    abstract public function getLastElement();
    abstract public function getAllElements();
    abstract public function clear();
}