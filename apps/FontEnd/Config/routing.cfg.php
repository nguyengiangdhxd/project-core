<?php
$r = array(
    '__urlSuffix__' => '.html',
    '__remap__' => array(
        #'route'=>'customer/default' // thay đổi hiển thị thì ở đây
        'route' => 'customer_profile/default'
        #'route'=>'Dasboard/default'
    ),
    '/' => array(
        'route'=>'Home/default'
    ),
//    'tin-tuc/{code:[0-9]+}' => array( // menu của tin tức
//        'route' => 'ListNews'
//    ),
    'tin-tuc' => array( // menu của tin tức
        'route' => 'ListNews'
    ),
//    'tin-tuc/chi-tiet-bai-viet/{id:[_a-zA-Z0-9-]+}' => array(
//    'route' => 'DetailNews'),
    'chi-tiet-bai-viet' => array(
        'route' => 'DetailNews'),

);
return $r;