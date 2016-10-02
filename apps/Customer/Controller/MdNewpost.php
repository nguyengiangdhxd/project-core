<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 7/9/2016
 * Time: 2:07 PM
 */
namespace Customer\Controller;


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

        return $this->renderComponent();
    }

    public function executeGetParam(){
        $title = $this->post('title'); // tiêu đề bài viết
        $summary = $this->post('summary'); // tóm tắt nội dung
        $content = $this->post('content'); // nội dung của baig biết
        $author = $this->post('author'); // tên tác giả
        $category = $this->post(''); // danh mục của bải viết


    }

}