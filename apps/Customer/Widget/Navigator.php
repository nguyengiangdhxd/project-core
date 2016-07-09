<?php
use CMSBackend\Library\CMSBackendAuth;
use Flywheel\Base;
use Flywheel\Html\Widget\Menu;

class Navigator extends Menu {
    #public $viewFile = 'navigator';
    public $viewFile = 'navigatorMenu';
    private $_menus = [];
    protected function _init() {
        parent::_init();
        $this->viewPath = Base::getApp()->getController()->getTemplatePath() .DIRECTORY_SEPARATOR .'Widget' .DIRECTORY_SEPARATOR;
        //cart

        //trading order
        $this->_menus['dashboard'] = [
            'label' => 'Dashboard',
            'url' => ['Customer/default'],
            'items' => [],
            'icon' => 'pg-home',
            'id' =>'_home'
        ];

        //finance
//        $this->_menus['product'] = [
//            'label' => 'Sản phẩm',
//            'url' => 'javascript:',
//            'icon' => 'fa fa-list',
//            'items' => [
//                [
//                    'label' => 'DS sản phẩm',
//                    'url' => 'danh-sach-san-pham',
//                    'icon' => 'ds',
//                    'id' => '_product_list',
//                ],
//                [
//                    'label' => 'Up file giá',
//                    'url' => 'price_policy/upload_items_price',
//                    'icon' => 'up',
//                    'id' => '_upload_items_price'
//                ]
//            ],
//            'id'=>'_product'
//        ];
        $this->_menus['content'] = [
            'label' => 'DS bài viêt',
            'url' => 'javascript:',
            'icon' => 'fa fa-list',
            'items' => [
                [
                    'label' => 'Thêm bài viết mới',
                    'url' => 'bai-viet-moi',
                    'icon' => 'ne',
                    'id' => ''
                ],
                [
                    'label' => 'DS Bài viết',
                    'url' => 'danh-sach-bai-viet',
                    'icon' => 'ds',
                    'id' => '',
                ],
                [
                    'label' => 'DS Blogger',
                    'url' => 'blogger',
                    'icon' => 'bo',
                    'id' => '',
                ],
            ]

        ];
        $this->_menus['learn'] = [
            'label' => 'Học tiếng',
            'url' => 'javascript:',
            'icon' => 'fa fa-graduation-cap',
            'items' => [
                [
                    'label' => 'Học tiếng trung',
                    'url' => 'hoc-tieng-trung',
                    'icon' => 'CN',
                    'id' => '',
                ],
                [
                    'label' => 'Học tiếng Việt',
                    'url' => 'hoc-tieng-trung',
                    'icon' => 'Vn',
                    'id' => '',
                ],
            ]
        ];
        $this->_menus['profile'] = [
            'label' => 'Cá nhân',
            'url' => 'customer_profile',
            'icon' => 'fa fa-user',
            'items' => [],
            'id' =>'_customer_profile'
        ];


        //profiles
//        $this->_menus['addon'] = [
//            'label' => 'Công cụ',
//            'url' => 'addon',
//            'icon' => 'fa fa-wrench',
//            'items' => [],
//            'id' =>'_addon'
//        ];

        $this->_buildMenu();
    }


    private function _buildMenu() {
        foreach($this->_menus as $m) {
            if (!empty($m['items']) || (isset($m['url']) && $m['url'] != '#')) {
                $this->items[] = $m;
            }
        }
    }

    public function end() {
        return $this->render(array(
            'items' => $this->items,
            'deep' => $this->deep
        ));
    }
} 