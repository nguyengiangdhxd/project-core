<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 5/9/2016
 * Time: 10:15 PM
 */

namespace FontEnd\Controller;

use Flywheel\Html\Widget\Menu;

class Home extends CustomerBase
{

    public function executeDefault()
    {
        $this->setLayout('home');
        $this->setView("Customer/home");
        $menus = \Menus::select()->execute();
        $this->view()->assign('variable',$menus);
        $menus = \Menus::select();
        return $this->renderComponent();
    }
}