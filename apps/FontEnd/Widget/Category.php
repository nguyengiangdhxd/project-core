<?php
use Flywheel\Base;

/**
 * Created by PhpStorm.
 * User: pc
 * Date: 6/12/2016
 * Time: 4:15 PM
 */
class Category extends \Flywheel\Html\Widget\Menu
{
    public $viewFile = 'category';
    private $_menus = [];
    protected function _init()
    {

        $this->viewPath = Base::getApp()->getController()->getTemplatePath() . DIRECTORY_SEPARATOR . 'Widget' . DIRECTORY_SEPARATOR;
    }

}