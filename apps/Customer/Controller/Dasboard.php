<?php
/**
 * Created by PhpStorm.
 * User: HOANGGIANG
 * Date: 4/3/2016
 * Time: 5:53 PM
 */

namespace Customer\Controller;


class Dasboard extends CustomerBase  {

    public function executeDefault()
    {
        $this->setLayout('default');  // đã xét nmsgu
        $this->setView( 'Customer/home');
        return $this->renderComponent();
    }
}