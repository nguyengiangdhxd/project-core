<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 6/12/2016
 * Time: 10:35 AM
 */

namespace FontEnd\Controller;


use Flywheel\Db\Manager;

class ListNews extends CustomerBase
{

    public function executeDefault()
    {

        $this->setLayout('listViews');
//        $code = $this->get('code','STRING','');
//        $news = \News::select()
//            ->andWhere('menu_id = :code')
//            ->setParameter(':code',$code)
//            ->execute()
//        ;
//        $conn  = Manager::getConnection();
//        $qb = $conn->createQuery()
//            ->select('u.name')
//            ->from('users', 'u')
//            ->innerJoin('u', 'phonenumbers', 'p', 'p.is_primary = 1');
//        var_dump($qb->getSQL());die();

        $this->setView('Customer/listNews');
        return $this->renderComponent();
    }

    /**
     * hàm lấy thông tin bài viết có phân trang
     * @param $page
     */
    private function getNews($page){
        $connection = Manager::getConnection();



    }
}