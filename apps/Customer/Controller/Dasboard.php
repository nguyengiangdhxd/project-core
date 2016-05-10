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
        #$this->setLayout('default');  // đã xét nmsgu
        $this->setView( 'Customer/home');
        $a = 3;
        $this->view()->assign('a',$a);
        return $this->renderComponent();
    }
    public function executeLoadPost(){
        $post = new \Posts();

         $x = $post->findOneById('a');
        $b = $post->save();
        $c = $post->delete();

    }

}