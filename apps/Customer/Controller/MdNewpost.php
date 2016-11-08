<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 7/9/2016
 * Time: 2:07 PM
 */
namespace Customer\Controller;


use Flywheel\Db\Type\DateTime;
use Flywheel\Http\Request;

class MdNewpost extends CustomerBase
{

    public function executeDefault()
    {
        $this->setView('Madarin/newpost');
        $customer = \Customer::select()->execute();
        $this->view()->assign([
            'customer' => $customer
        ]);
        // nhận giá trị khi submit form
        $title = $this->post('title'); // tiêu đề bài viết
        $summary = $this->post('summary'); // tóm tắt nội dung
        $content = $this->post('content'); // nội dung của baig biết
        $author = $this->post('author'); // tên tác giả
        $menu = $this->post('category'); // danh mục của bải viết
        // sau khi lấy được giá trị thì lưu lại vào trong
        $new = new \News();
        $new->setTitle($title);
        $new->setSummary($summary);
        $new->setContent($content);
        $new->setMenuId($menu);
        $new->setCreatedTime(new DateTime());
        $new->save();

        return $this->renderComponent();
    }
    

}