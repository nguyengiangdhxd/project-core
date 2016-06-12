<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 6/13/2016
 * Time: 2:26 AM
 */

namespace Customer\Controller;



class MdListNews extends \Customer\Controller\CustomerBase
{

    public function executeDefault()
    {
        $this->setLayout('default');
        $this->setView('Madarin/listNews');
        return $this->renderComponent();
    }
}