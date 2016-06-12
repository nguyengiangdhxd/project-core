<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 6/12/2016
 * Time: 3:16 PM
 */

namespace FontEnd\Controller;


class DetailNews extends CustomerBase
{

    public function executeDefault()
    {
        $this->setLayout('detailNews');
        $this->setView('Customer/detailNews');
        return $this->renderComponent();
    }
}