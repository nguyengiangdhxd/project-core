<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 5/9/2016
 * Time: 10:15 PM
 */

namespace FontEnd\Controller;

class Home extends CustomerBase
{

    public function executeDefault()
    {
        $this->setLayout('home');
        $this->setView("Customer/home");
        $this->view()->assign('variable',"nguyen hoang giang đã cấu hính thành công :D");
        return $this->renderComponent();
    }
}