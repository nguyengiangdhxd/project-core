<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 7/9/2016
 * Time: 2:07 PM
 */
namespace Customer\Controller;


class MdNewpost extends CustomerBase
{

    public function executeDefault()
    {
        $this->setView('Madarin/newpost');
        return $this->renderComponent();
    }
}