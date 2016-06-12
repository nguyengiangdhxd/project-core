<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 6/12/2016
 * Time: 10:35 AM
 */

namespace FontEnd\Controller;


class ListNews extends CustomerBase
{

    public function executeDefault()
    {
        $this->setLayout('listViews');
        $this->setView('Customer/listNews');
        return $this->renderComponent();
    }
}