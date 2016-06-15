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

        $code = $this->get('code','INT',1);
        if(!$code){
            $this->redirect('/tin-tuc');
        }
        $queryNews = \News::select();
        $queryNews->where('`id` =  :id');
        $queryNews->setParameter(':id',$code);
        $queryNews->setFirstResult(0)->setMaxResults(1);
        $newDetail = $queryNews->execute();
        $arr = [];
        foreach ($newDetail as $item) {
            /** @var $item \News */
            $arr['title'] = $item->getTitle();
            $arr['content'] = $item->getContent();
        }
        $this->view()->assign('detail',$arr);
        return $this->renderComponent();
    }
}