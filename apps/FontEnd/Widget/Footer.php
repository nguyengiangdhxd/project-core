<?php
use Flywheel\Base;

/**
 * Created by PhpStorm.
 * User: pc
 * Date: 5/10/2016
 * Time: 11:46 PM
 */
class Footer extends \Flywheel\Html\Widget\Menu
{
    public $viewFile = 'footer';
    private $_menus = [];
    protected function _init()
    {
        #$this->_buildMenu();

        $this->viewPath = Base::getApp()->getController()->getTemplatePath() . DIRECTORY_SEPARATOR . 'Widget' . DIRECTORY_SEPARATOR;
    }

    /* public function end() {
         return $this->render([
             'items' => $this->items,
             'auth' => Base::getApp()->getController()->customerLogin()
         ]);
     }*/
    /*private function _buildMenu() {
        foreach($this->_menus as $m) {
            if (!empty($m['items']) || (isset($m['url']) && $m['url'] != '#')) {
                $this->items[] = $m;
            }
        }
    }*/

}