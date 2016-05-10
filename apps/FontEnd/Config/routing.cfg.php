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
);
return $r;