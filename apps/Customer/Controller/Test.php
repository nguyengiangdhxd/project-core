<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/14/2015
 * Time: 6:15 PM
 */

namespace Customer\Controller;

use BizWeb\BizWebClient;
use BizWeb\BizWebService;
use Core\CustomerAuth;
use Core\Logger;
use Core\Queue;
use Flywheel\Db\Type\DateTime;
use Haravan\HaravanClient;
use Mongodb\ConnectMongoDB;
use Mongodb\ItemsRepository;

class Test extends CustomerBase
{

    public function executeDefault()
    {
        $client = BizWebService::createClient(CustomerAuth::getInstance()->getCusId());
        $service = new BizWebService($client);
        $repo = new ItemsRepository(ConnectMongoDB::getConnection());
        /** @var \MongoDb\Items $item */
        $item = $repo->findOneById("568b6e4481a40d5c7f000029");
        $service->syncItem($item);

        $client = new BizWebClient('kiennx.bizwebvietnam.net', '47c2aef49a7c4247aa2ab05f0b9a7918', '9d5fe526862ede00fe126768d8f212ce', '4506fc948bfdb2cfb3e27a1ef77e24fa');
        $test = $client->call('GET', '/admin/products/98.json');
        # $test = $client->call('GET','/admin/products.json', ['id'=>922161]);#922161

        // TODO: Implement executeDefault() method.
        // ["shop_domain" : "kiennx.bizwebvietnam.net",
        // "access_token" : "47c2aef49a7c4247aa2ab05f0b9a7918"
        // sau này cấu hình fix cứng
        // $api_key : 9d5fe526862ede00fe126768d8f212ce
        // $secret  : 4506fc948bfdb2cfb3e27a1ef77e24fa
        // có thể lấy lại giá trị của $api_key : thông qua quy trình
        /*POST /admin/products.json*/

        /*$test = $client->call('POST','/admin/products.json',[
            'name' => "Test22", // trường này là bắt buộc
            'alias' => 'san-pham-test-22',
            'vendor' =>'Alitech', // nhà cung cấp
            'options' => [  //đây là các thuộc tính của hàng
                [
                    'name' => 'Gia tri hang', // tên mặt hàng
                ],
                [
                   'name' => 'Mau sac', // màu sắc của đơn hàng
                ],
                [
                    'name' => 'Kích thước' // kích thước của đơn hàng
                ]
            ],
            'product_type'=> "Dày dép", // loại sản phẩm
            'tags' => 'Emotive, Flash Memory, MP3, Music' ,// tag cho tên sản phẩm
            'compare_at_price_min' => 0,
            'compare_at_price_varies' =>  false,
            'meta_title' =>'san-pham-test-meta',
            'meta_description' => 'áo hịn , áo hịn đây',
            'content' =>  'đây là đoạn thông tin về sản phẩm để đánh giá nó , đây là đoạn thông tin về sản phẩm để đánh giá nó',
            'variants' => [ // mô tả chi tiết về sản phẩm và các thuộc tính chi tiết
                [
                "title" => "Do 35",
                "option1" => '12345566',
                'option2' => 'Do',
                'option3' => '43',
                "barcode" => "1234_pink",
                "sku" =>"IPOD2008PINK" , // mã sku
                "fulfillment_service" => "manual",
                'price' => 10000,
                'compare_at_price' => 100,
                'weight' => 12.5,
                    'position' => 1
                ]
            ],
            'images' =>[ // gửi ảnh cho sản phẩm
                ["src"=> "http://xemanh.net/wp-content/uploads/2015/08/hinh-nen-gai-xinh-cho-may-tinh.jpg" ] ,
                ["src"=> "http://hinhnendepnhat.net/wp-content/uploads/2014/06/hinh-nen-girl-xinh-viet-nam-xinh-oi-la-xinh.jpg" ],
                ["src"=> "http://www.12cunghoangdao.com.vn/wp-content/uploads/2015/09/tu-vi-12-cung-hoang-dao-thu-ba-ngay-15-9-2015.jpg" ]
            ],

        ]);*/

        /*  $test = $client->call('POST','/admin/products.json',[
              'name' => "Test24", // trường này là bắt buộc
              'alias' => 'san-pham-test-24',
              'vendor' =>'Alitech', // nhà cung cấp
              'options' => [  //đây là các thuộc tính của hàng
                  [
                      'name' => 'Gia tri hang', // tên mặt hàng
                  ],
                  [
                      'name' => 'Mau sac', // màu sắc của đơn hàng
                  ],
                  [
                      'name' => 'Kích thước' // kích thước của đơn hàng
                  ]
              ],
              'product_type'=> "Dày dép", // loại sản phẩm
              'tags' => 'Emotive, Flash Memory, MP3, Music' ,// tag cho tên sản phẩm
              'compare_at_price_min' => 0,
              'compare_at_price_varies' =>  false,
              'meta_title' =>'san-pham-test-meta',
              'meta_description' => 'áo hịn , áo hịn đây',
              'content' =>  'đây là đoạn thông tin về sản phẩm để đánh giá nó , đây là đoạn thông tin về sản phẩm để đánh giá nó',
              'variants' => [ // mô tả chi tiết về sản phẩm và các thuộc tính chi tiết
                  [
                      "title" => "Do 35",
                      "option1" => '12345566',
                      'option2' => 'Do',
                      'option3' => '43',
                      "barcode" => "1234_pink",
                      "sku" =>"IPOD2008PINK" , // mã sku
                      "fulfillment_service" => "manual",
                      'price' => 10000,
                      'compare_at_price' => 100,
                      'weight' => 12.5,
                      'position' => 1
                  ]
              ],
              'images' =>[ // gửi ảnh cho sản phẩm
                  ["src"=> "http://xemanh.net/wp-content/uploads/2015/08/hinh-nen-gai-xinh-cho-may-tinh.jpg" ] ,
                  ["src"=> "http://hinhnendepnhat.net/wp-content/uploads/2014/06/hinh-nen-girl-xinh-viet-nam-xinh-oi-la-xinh.jpg" ],
                  ["src"=> "http://www.12cunghoangdao.com.vn/wp-content/uploads/2015/09/tu-vi-12-cung-hoang-dao-thu-ba-ngay-15-9-2015.jpg" ]
              ],

              "metafields"=> [
                  [
                  "key" => "new",
                  "value"=> "newvalue",
                  "value_type" => "string",
                  "namespace" => "global"
                  ] ,// gửi kèm theo giá trị metafield
                  [
                      "key" => "new1",
                      "value"=> "newvalue1",
                      "value_type" => "string",
                      "namespace" => "global"
                  ],
                  [
                      "key" => "new2",
                      "value"=> "newvalue2",
                      "value_type" => "string",
                      "namespace" => "global"
                  ]

              ]
          ]);*/

        var_dump($test);
        die;
    }

    /**
     * lấy dữ liệu metafileds theo id của product
     */
    public function executeT()
    {


        $queue = Queue::factory('integration_synchronized');

        $item_id = $queue->pop();
        $logger = Logger::factory('synchronized');
        $repo = new ItemsRepository(ConnectMongoDB::getConnection());
        /** @var \MongoDb\Items $item */
        $item = $repo->findOneById($item_id);
        if (!$item) {
            $logger->error('item not found with id:' . $item_id);
            return;
        } else {
            //Luuhieu: về sau sẽ có setting của items hoặc customer đồng bộ qua kênh nào.
            // Cần check và lấy thêm ở đây. Trước mắt mặc định là bizweb
            $client = BizWebService::createClient($item->getCustomerId());
            $server = new BizWebService($client);
            $server->syncItem($item);
        }
    }

    /**
     * xóa một bản ghi , xóa thành công trả về null
     */
    public function executeDelete()
    {
        $client = new BizWebClient('kiennx.bizwebvietnam.net', '47c2aef49a7c4247aa2ab05f0b9a7918', '9d5fe526862ede00fe126768d8f212ce', '4506fc948bfdb2cfb3e27a1ef77e24fa');
        $test = $client->call('DELETE', '/admin/products/983930.json');

        var_dump($test);
        die();
    }


    /**
     * tạo mới
     * gửi kèm ảnh trong varient ( theo option thuộc tính của sản phẩm )
     * status :: thành công
     */
    public function executeSendImage()
    {

        $client = new BizWebClient('kiennx.bizwebvietnam.net', 'f4fd9e1e1cc343bbb6ec668930ff7f2e', '9d5fe526862ede00fe126768d8f212ce', '4506fc948bfdb2cfb3e27a1ef77e24fa');
        $test = $client->call('POST', '/admin/products.json', [
            'name' => "gui kem metafile version 3332", // trường này là bắt buộc
            # 'alias' => 'quan-bo-hin-2', // cái nay có thể tự sinh
            'vendor' => 'Alitech', // nhà cung cấp
            'options' => [
            ],
            'product_type' => "Dày dép", // loại sản phẩm
            'tags' => 'Emotive, Flash Memory, MP3, Music',// tag cho tên sản phẩm
            'compare_at_price_min' => 0,
            'compare_at_price_varies' => false,
            'meta_title' => 'san-pham-test-meta',
            'meta_description' => 'áo hịn , áo hịn đây',
            'content' => 'đây là đoạn thông tin về sản phẩm để đánh giá nó , đây là đoạn thông tin về sản phẩm để đánh giá nó',
            'variants' => [ // mô tả chi tiết về sản phẩm và các thuộc tính chi tiết
                [
                    "barcode" => "1234_pink",
                    "sku" => "IPOD2008PINK", // mã sku
                    "fulfillment_service" => "manual",
                    'price' => 10000,
                    'compare_at_price' => 100,
                    'weight' => 12.5,
                    'position' => 1,
                    "image_position" => 1
                ],

            ],
            'images' => [ // gửi ảnh cho sản phẩm
                ["src" => "http://gd4.alicdn.com/bao/uploaded/i4/15211448/TB2e8FQgpXXXXaNXXXXXXXXXXXX_!!15211448.jpg",'position' => 4],
                ["src" => "http://hinhnendepnhat.net/wp-content/uploads/2014/06/hinh-nen-girl-xinh-viet-nam-xinh-oi-la-xinh.jpg",'position' => 3],
                ["src" => "http://www.12cunghoangdao.com.vn/wp-content/uploads/2015/09/tu-vi-12-cung-hoang-dao-thu-ba-ngay-15-9-2015.jpg",'position' => 2],
                #["src"=> "//gd4.alicdn.com/bao/uploaded/i4/15211448/TB2e8FQgpXXXXaNXXXXXXXXXXXX_!!15211448.jpg" ]
            ]
        ]);

        /*   $dataId = $test['id'];
           var_dump($dataId);die;*/

        #var_dump($test);
        return $this->renderText(json_encode($test));
        # die();
    }

    public function executeMetadata()
    {
        $client = new BizWebClient('kiennx.bizwebvietnam.net', 'f4fd9e1e1cc343bbb6ec668930ff7f2e', '9d5fe526862ede00fe126768d8f212ce', '4506fc948bfdb2cfb3e27a1ef77e24fa');
        $test = $client->call('PUT', '/admin/products/ 1356531.json', [
            "id" => 1356531,
            "metafields" => [
                [
                    "key" => "link gốc",
                    "value" => "newvalue",
                    "value_type" => "string",
                    "namespace" => "IDE"
                ]
            ]

        ]); # theem id
        return $this->renderText(json_encode($test));
    }

    /**
     * update ảnh trong varient
     * lưu ý : cần truyền id của varient  vào vào trong "variant_ids" của image ,
     * chú ý bổ sung truyền id cho cả varient
     */
    public function executePutProduct()
    {
        $client = new BizWebClient('kiennx.bizwebvietnam.net', 'f4fd9e1e1cc343bbb6ec668930ff7f2e', '9d5fe526862ede00fe126768d8f212ce', '4506fc948bfdb2cfb3e27a1ef77e24fa');
        $test = $client->call('PUT', '/admin/products/1143435.json', [
            'id' => 985271,
            'name' => "Test27", // trường này là bắt buộc
            'alias' => 'san-pham-test-2745',
            'vendor' => 'Alitech', // nhà cung cấp
            'options' => [  //đây là các thuộc tính của hàng
                [
                    'name' => 'Gia tri hang', // tên mặt hàng
                ],
                [
                    'name' => 'Mau sac', // màu sắc của đơn hàng
                ],
                [
                    'name' => 'Kích thước' // kích thước của đơn hàng
                ]
            ],
            'product_type' => "Dày dép", // loại sản phẩm
            'tags' => 'Emotive, Flash Memory, MP3, Music',// tag cho tên sản phẩm
            'compare_at_price_min' => 0,
            'compare_at_price_varies' => false,
            'meta_title' => 'san-pham-test-meta',
            'meta_description' => 'áo hịn , áo hịn đây',
            'content' => 'đây là đoạn thông tin về sản phẩm để đánh giá nó , đây là đoạn thông tin về sản phẩm để đánh giá nó',
            'variants' => [ // mô tả chi tiết về sản phẩm và các thuộc tính chi tiết
                [
                    "id" => 1778997,
                    "title" => "Do 35",
                    "option1" => '12345566',
                    'option2' => 'Do',
                    'option3' => '43',
                    "barcode" => "1234_pink",
                    "sku" => "IPOD2008PINK", // mã sku
                    "fulfillment_service" => "manual",
                    'price' => 10000,
                    'compare_at_price' => 100,
                    'weight' => 12.5,
                    'position' => 1,
                    "image_position" => 2
                ]
            ],
            'images' => [ // gửi ảnh cho sản phẩm
                ["src" => "http://xemanh.net/wp-content/uploads/2015/08/hinh-nen-gai-xinh-cho-may-tinh.jpg",
                    "variant_ids" => [1778997]
                ],
                ["src" => "http://hinhnendepnhat.net/wp-content/uploads/2014/06/hinh-nen-girl-xinh-viet-nam-xinh-oi-la-xinh.jpg",
                    "variant_ids" => []
                ],
                ["src" => "http://www.12cunghoangdao.com.vn/wp-content/uploads/2015/09/tu-vi-12-cung-hoang-dao-thu-ba-ngay-15-9-2015.jpg",
                    #  "variant_ids" =>[1778997]
                ]
            ],

        ]);

        /* $data = json_encode($data);
         echo $data; die();*/

        return $this->renderText(json_encode($test));

    }

    /**
     * lấy về metafile theo product
     */
    public function executeGetMetaFiledFromProduct()
    {
        $client = new BizWebClient('kiennx2.bizwebvietnam.net', '8f80d4f470864575b93e6dfeb28c4eb8', '9d5fe526862ede00fe126768d8f212ce', '4506fc948bfdb2cfb3e27a1ef77e24fa');
        $test = $client->call('GET', '/admin/products/1401010/metafields.json');
        # GET /admin/products/#{id}/metafields.json
        return $this->renderText(json_encode($test));
    }

    /**
     * gửi metafiles cho toàn bộ store
     * gửi metafields thành công với tiếng việt
     */
    public function executeGetMeta()
    { // 1356686
        $client = new BizWebClient('kiennx.bizwebvietnam.net', '47c2aef49a7c4247aa2ab05f0b9a7918', '9d5fe526862ede00fe126768d8f212ce', '4506fc948bfdb2cfb3e27a1ef77e24fa');
        $test = $client->call('POST', '/admin/metafields.json', [
            "namespace" => "inventory",
            "key" => "手机版您",#手机版您
            "value" => 25,
            "value_type" => "integer"
        ]);
        var_dump($test);
        die();

    }

    /**
     * tham số cần là giá id của product sản phẩm
     * tạo mới metafiles kèm theo product
     */
    public function executePostMetaProduct()
    {
        $client = new BizWebClient('kiennx.bizwebvietnam.net', '47c2aef49a7c4247aa2ab05f0b9a7918', '9d5fe526862ede00fe126768d8f212ce', '4506fc948bfdb2cfb3e27a1ef77e24fa');
        $test = $client->call('POST', '/admin/products/985271/metafields.json', [
            "namespace" => "inventory",
            "key" => "nguyễn hoàng giang",#手机版您
            "value" => 25,
            "value_type" => "integer"
        ]);
        echo $test['key'];
        die;
    }

    /**
     * get metafileds theo product
     */
    public function executeGetMetaProduct()
    {
        $client = new BizWebClient('kiennx.bizwebvietnam.net', '47c2aef49a7c4247aa2ab05f0b9a7918', '9d5fe526862ede00fe126768d8f212ce', '4506fc948bfdb2cfb3e27a1ef77e24fa');
        $test = $client->call('GET', '/admin/products/985271/metafields.json');

        $test_convert = $test[0]['key'];

        return $this->renderText(json_encode($test));
    }


    /**
     * tham số cần truyền là id của sản phẩm và id của metafiles
     * ko thể sửa lại giá trị của key
     * sửa lại giá trị của meta file trong product
     */
    public function executePutMetaProduct()
    {
        $client = new BizWebClient('kiennx.bizwebvietnam.net', '47c2aef49a7c4247aa2ab05f0b9a7918', '9d5fe526862ede00fe126768d8f212ce', '4506fc948bfdb2cfb3e27a1ef77e24fa');
        $test = $client->call('PUT', '/admin/products/985271/metafields/58120.json', [
            "namespace" => "inventory",
            "key" => "手机版您 拍无模特",#手机版您 giá trị này là ko thể thay đổi
            "value" => 2578,
            "value_type" => "integer"
        ]);
        var_dump($test);
        die;
        /* $create_time = $test['created_on'];
         $key['key'] = $test['key'];
         echo $create_time.$key;
         die;*/

    }

    public function executeGetProductId()
    {
        $client = new BizWebClient('kiennx.bizwebvietnam.net', '47c2aef49a7c4247aa2ab05f0b9a7918', '9d5fe526862ede00fe126768d8f212ce', '4506fc948bfdb2cfb3e27a1ef77e24fa');
        $test = $client->call('GET', '/admin/products/992501.json');
        # return $this->renderText(json_encode($test));
        var_dump($test);
        die();
    }

    public function executeGetProductTest()
    {
        $client = new BizWebClient('kiennx2.bizwebvietnam.net', '8f80d4f470864575b93e6dfeb28c4eb8');
        $test = $client->call('GET', '/admin/products/1408623.json');
        # return $this->renderText(json_encode($test));
       return $this->renderText(json_encode($test));
    }


    public function executeSendDataFromDb()
    {
        $client = new BizWebClient('kiennx.bizwebvietnam.net', '1771acd30fc846c3836d6644a11f6b23');
        $sever = new BizWebService($client);
        $mandango = ConnectMongoDB::getConnection();
        $itemRepo = new \Mongodb\ItemsRepository($mandango);
        $Item = $itemRepo->createQuery()->all();
        foreach ($Item as $itemValue) {
            $sever->syncItem($itemValue);
        }
        return $this->renderText(json_encode($sever));
        #var_dump($Item);die();
    }

    /* public function executeSetItems(){
         $mandango = ConnectMongoDB::getConnection();
         $item = new \Mongodb\Items($mandango);
         // set dữ liệu tạm
         $item->setCreatedTime( new DateTime());
         $item->setBodyImages([]);
         $item->setCustomerId('');
         $item->setUid('');
         $item->setOriginItemId('');
         $item->setHomeLand('');
         $item->setTitle('Nike耐克官方NIKEHAYWARD2.0雙肩包BA5065-421-001');
         $item->setImages([]);
         $item->setOptions([]);
         $item->save();
     }*/

    public function executeTestTimeFunction()
    {
        $result = 0;
        for ($i = 0; $i < 100000; $i++) {
            $result += $i;
        }
        return $result;
    }

    public function executeTime()
    {

        return $this->executeTestTimeFunction();
    }


    public function executeSendHaravan()
    {

        $client = new BizWebClient('http://itemd-shop.myharavan.com/', 'f4fd9e1e1cc343bbb6ec668930ff7f2e', '9d5fe526862ede00fe126768d8f212ce', '4506fc948bfdb2cfb3e27a1ef77e24fa');
        $test = $client->call('POST', '/admin/products.json', [
            'name' => "gửi ảnh ko có http1", // trường này là bắt buộc
            # 'alias' => 'quan-bo-hin-2', // cái nay có thể tự sinh
            'vendor' => 'Alitech', // nhà cung cấp
            'options' => [  //đây là các thuộc tính của hàng
                array('name' => 'Gia tri hang'), // tên mặt hàng)
                [
                    'name' => 'Mau sac', // màu sắc của đơn hàng
                ],
                [
                    'name' => 'Kích thước' // kích thước của đơn hàng
                ]
            ],
            'product_type' => "Dày dép", // loại sản phẩm
            'tags' => 'Emotive, Flash Memory, MP3, Music',// tag cho tên sản phẩm
            'compare_at_price_min' => 0,
            'compare_at_price_varies' => false,
            'meta_title' => 'san-pham-test-meta',
            'meta_description' => 'áo hịn , áo hịn đây',
            'content' => 'đây là đoạn thông tin về sản phẩm để đánh giá nó , đây là đoạn thông tin về sản phẩm để đánh giá nó',
            'variants' => [ // mô tả chi tiết về sản phẩm và các thuộc tính chi tiết
                [
                    "title" => "Do 35",
                    "option1" => '12345566',
                    'option2' => '【lông ánh sáng mẫu  Lớn 黃',
                    'option3' => 'nguyengiang',
                    "barcode" => "1234_pink",
                    "sku" => "IPOD2008PINK", // mã sku
                    "fulfillment_service" => "manual",
                    'price' => 10000,
                    'compare_at_price' => 100,
                    'weight' => 12.5,
                    'position' => 1,
                    "image_position" => 1
                ],
                [
                    "title" => "Xanh 35",
                    "option1" => '10000',
                    'option2' => '【lông ánh sáng mẫu  Lớn 黃',
                    'option3' => 'nguyengiang',
                    "barcode" => "1234_pink",
                    "sku" => "IPOD2008PINK", // mã sku
                    "fulfillment_service" => "manual",
                    'price' => '80000',
                    'compare_at_price' => 100,
                    'weight' => 12.5,
                    'position' => 2,
                    "image_position" => 2
                ]

            ],
            'images' => [ // gửi ảnh cho sản phẩm
                ["src" => "http://gd4.alicdn.com/bao/uploaded/i4/15211448/TB2e8FQgpXXXXaNXXXXXXXXXXXX_!!15211448.jpg"],
                ["src" => "http://hinhnendepnhat.net/wp-content/uploads/2014/06/hinh-nen-girl-xinh-viet-nam-xinh-oi-la-xinh.jpg"],
                ["src" => "http://www.12cunghoangdao.com.vn/wp-content/uploads/2015/09/tu-vi-12-cung-hoang-dao-thu-ba-ngay-15-9-2015.jpg"],
                #["src"=> "//gd4.alicdn.com/bao/uploaded/i4/15211448/TB2e8FQgpXXXXaNXXXXXXXXXXXX_!!15211448.jpg" ]
            ]
        ]);

        /*   $dataId = $test['id'];
           var_dump($dataId);die;*/

        #var_dump($test);
        return $this->renderText(json_encode($test));
        # die();
    }

    public function executeSendProductImageHaravan()
    {
        $client = new HaravanClient('itemd-shop.myharavan.com', 'Z_M_Nn7GSZShgErXXegACIfIIYotQCPvTaQwe1Px3Dslz3YBsXseUa9nWEoI55rXafj_ziKu7aOwSRRhGUIxJermcAMfdaBwuLgdk5x5XItDlnIMUzUM16yozqYcuVH4ifddvBKcAS6LCXnoRbKBZX1zvyH0kzf43DGIs_uOZwdRDLYO74NsK02wMnt5gz17VWIKjrwED01vvyNyddzwrWU1J7ViZ8dZLJnGCqXh9He1v-r0ZcOmiGpuVxou43KPQ_9HFs-Gw5S_FLMO1FIu7FVHUbrpxr2lAi0sNKInf1S9QG9A_eJENoYwSlPdoGdOjOBK-fpI0g4nbnr4tzQ4f_2HhfDccQciEgZ6dfr_cx3xmlr5Zc6SpPOuks9JuLgmEVYuiTvVuuygI03_GoR9nQPEudbbUHnPo_EtzwTeatBjUrTA7Uau2-u1zBfm4UfiJXOobUFwQWumcdT2xQV_f214kMckrrvztO9IzBOQUWE2r8ErX_WAGXDyU0a7bHsyNSHstA');
        $test = $client->call('POST', '/admin/products/1001713017/images.json', ["image" => [
            "position" => 1,
            "attachment" => "R0lGODlhbgCMAPf\/APbr48VySrxTO7IgKt2qmKQdJeK8lsFjROG5p\/nz7Zg3\nMNmnd7Q1MLNVS9GId71hSJMZIuzTu4UtKbeEeakhKMl8U8WYjfr18YQaIbAf\nKKwhKdKzqpQtLebFortOOejKrOjZ1Mt7aMNpVbAqLLV7bsNqR+3WwMqEWenN\nsZYxL\/Ddy\/Pm2e7ZxLlUQrIjNPXp3bU5MbhENbEtLtqhj5ZQTfHh0bMxL7Ip\nNsNyUYkZIrZJPcqGdYIUHb5aPKkeJnoUHd2yiJkiLKYiKLRFOsyJXKVDO8up\nosFaS+TBnK4kKti5sNaYg\/z49aqYl5kqLrljUtORfMOlo\/36+H4ZH8yDYq0f\nKKFYTaU9MrY8MrZBNXwXHpgaIdGVYu\/byLZNP9SaZLIyOuXCtHkpJst+Wpcm\nLMyCa8BfP9GMb9KQdPDd1PPk1sd5VP79\/L5dQZ0bI9+ymqssK9WcfIoXHdzG\nxdWWfteib79lSr1YP86MYurQxKdcUKdMQr5ZSfPs6YEZH8uhl4oWIenMuurQ\nttmejaqoqsqBVaAcJLlJN5kvMLlZRMNsSL5fRak0LbdQQMVvSPjw6cJnRpkf\nKtmjhvfu5cJtT7IuOMVvWLY\/M\/37+o0YH9ibhtSYdObErc6HarM9NnYSGNGR\navLi09unje3WyeO8rsVrT7tdRtK3uffu6NWeaL9pTJIjJrM4NPbx8cdyX7M7\nPYYVHu7j4KgoNJAYIKtkV5o9MsOcldicis+RYNutfrhFOZ0hJbqinZ8bI8h5\nUObFuOfItJsfJrJfUOfIqc+PXqQtK8RnSbA4Mcd3Tm0SGbpXQ8aqp7RLNs+s\novHfzpVhV9iggMd1TLtbRKUdKXEQFsd4XrZRPLIgMZUeJ+jKvrAlK6AhJ65A\nMpMpKuC3j5obIsRwS7hAN8l\/YtvDvnYXHbAoLI47SIUsOMenorF4gO\/m4+fH\npo4vLZ8oKMukqp0cJbhVSMV2UuPR0bAfMLIrLrg\/OcJwT8h+Vt+wn8eurLlh\nQrIfKHQOHHQOHf\/\/\/\/\/\/\/yH5BAEAAP8ALAAAAABuAIwAAAj\/AP8JHDhQXjpz\n\/PopXNiPn0OHDRMmbKhQIsOJFS1SxAhxI8SHFzVeDBnx48iNBAeeOkcxokeX\nFRdOnAlSokaaLXNujJkxo8iYHRkKtWkzZSsaOXkAWsoUECynsHgoqEW1qtVa\nU7Mq2Mq1K9cUW8GKTUG2rNkUHNByWMuWLdWva7t1W7UKG4S7eO\/ycEhQHgaK\nsL4VGGyocGE3br5929KuxQFFkEtIlgypsuUDmDMfWGRmUZvPoEHfGU36jgDT\nLQSoVt3IQ2sPsL0IUNZGlZ0H0lo00jEkCytWMspdGzBgn\/F9EBIWnKIQlqHB\nhA0bQpx48Z7UAkoEcMTdUeTJJSxf\/4akOTNnzqHb3GkjrUdp0gKwq77jWdod\nO7dNKWvhRUcWT6zYQI82xB03AAQNCdTKX\/xAAB10hfVCnRtbVIhIAy14oJoZ\nAXS4XXfdQaYIeOGJRx555Z1nRnrqqUeaMtIYY8dmn7Vg2yK57TYEgAzIQGBx\nxyXHj0A0OOTggxFKSN1iWwTTAIYanpYdMtFE4+GVIHrn3XeUmVhZeWiIMoOY\nnVQDGiTgKALJjIssIsADt0mjjI6+AXcDgQYi2M8\/7ijEwzRIFmBIL9NVV+EW\nVzyZ4Wqj9RBABchQWeWkV3aY5ZYjjgieeKL446mnjxwAiZVpliAjZqblt19\/\n\/7HCwIAFGv+X3J4s9fMckoYhphiTQTwJ5Wqn9dDDAWuMUUEFviTrS6STVlmp\npVmKqCkOn34aB6TIBAAOJeHZAYl6ptixSCL8edGbq8HFeqBDcygEyIOCGqYk\nkxUW4euiq7knbA\/gUDHGv\/\/ec2wFayQbaQWinOCslVhmSUq1\/gCDLJXacgtJ\nCYu4J66cjbAKoA3CxapnOgm9g+ughdK7xYX3Rinlvj2YYcYanVBBhTg2Axzw\nG4\/4k4bBzDZbKRUQP1LIsRSX6sgBZtwhzQP68ccbj7AWty4\/5igEoaC9dK3r\noVtgs4evvzKqb8wyQ0JFJzXXbDMVcQBQLTDGVmCssstKGs09oPT\/jQcRoBw9\nMamKgEOeeg\/gqBtvdVZSDnHFIQgRD4RxXWhiYEOQKNn4zncHzDIzHc0ZpHdy\nRicIQOypKDf7q3Pd96ABzSab+E1EIYIvS2o0ijA92gPZiCB1qwL+iJxL78Z7\n2NeHQrAK2YrCZva+bcgcujFUQIEG6WigonoCdLT9tr9UbIIAMMCEkkYacvvT\nxSgsBPKGJKBEAw4yjhx+hyn+PAJFfztyVdWOt5B3RehyimneFuwFvQxFyTSf\n25f1zCAqSFACDXTQ3gwSoDoElI5tZyBAINqnuhJ+Kg9vOIOaVnSHT5ECHucK\n0OMiBxJAPCdXmGseBLoBvei5rFEStB5m\/yBhjFJUIw50oIMoLvCpFRAADduj\nwxvUYMIqmvARCBiDeiwRBk+lQQTEq5qQ3CWdJSkGAlu4y9h66EBgAbF6QhSV\nMUpQilKcQRNLwIenfpFEJebBioC0ohrQQJ8QhMIfSwhgj2YouYTYUEmGqhBe\nFNBDH5otgmgLnRyLWMdq0GEGCMCHJjSBjzQE8pSChMLTCJBI4pXDBeuiiA1T\nprK7PK+SUPphsIQ1wSEag5OUKIUlyiAmAowClci0YizKILUAFi+WDQEEJOmF\nxlnMYnOVbOP0gkjBTdZRmDiwhCuywcRkmtOEpHjC1DzBABto4xqN5AcgdEXN\nNO4Ql0+CB2xctv9LM2SSgpXhZB0t0QlT+iMUkzinQquFihD452P0gGdGAPGN\nHKYxjbOAwBpxqU9+ApGXQgyoQDWRgASwoAMGMMAHDrnQhc5AkQPSU0NgYVF7\nQmAWKcBnPvc5HwGcbUVxJCInEfACQXQACUhFQkqRwAIOttScv9ABO21wA8k1\np5Z3mYXYdNqAjvLzbHDUpFCNIQoUdGAdHUhrUg2gVAOg4AXmvEAaOPEGaCCA\nAASQxBtIYYIq5kEHAaKHVfsRGB3eNBPYxKdXGVWGUnAzdOSxgyg+MIxhoDWt\nal3rUlXABEBeYBQIiMMm0AAKPBBAE1A4nTjWEIAzvGEFqsvDEHqEjZj\/wMKw\n1rwlVxerGkv4AxVoAOkEmXGMOKDgA8i1LFrRioSjKrWtKRVEQlXHBBSKQhLQ\nEG3tCHCLJaSWClD0zgHO8LBqDeIYNsDGTG4ryZtak4G7lZ6G2sBSfyCAaTK7\nAzfgQIEzoOC\/yKVsZS+bWeim1BsdqEG10oCANxDgDZwIRHa3O4hbaA91nlKB\nKA7QBhHo0VPwCFBtAdNea86CZVztKk8FUN5PjQIHxKWABihQBkHY+L\/HTa5l\nMetcAxvAG94wQAQAkA1SIIAUBvUHdkVLgBkMwrvkPSEkVtSCJ\/yCAJ5gZ20l\nwgObziITGk3xTqUHhWoxYQVdAIYINMBmO0TA\/8aCwHGOBbwOAvc4pXj2RieY\nIY69ttgfpJBEHOLQ5ArTAQ2SaPAb4lAC33XsoaxYhUx4kFVrZoKSYlYxbOzg\nPX8kAM1d6AILOuEDDQzBBCaIwJvhjOMAU7bOmE0qdMUhhFozQhVxiMWnuiAJ\nQTfZyahFQydWGwA1cbiZAJL0Qiht6UzoVsxetUQaJhEKZzhDBdh+A5s9AQxU\nq3rVN241ne0sa1rXWgjbqLUd3uqPUYhCFNDAxwzm3d3vjgF\/vTvAHegUaYbw\nwMSZyAR8oX0I2BwiC2eoQQ2srYJA6IDNb2ABqr39bVYDWMfkRgIVzs1xdEOD\nCjhQ4nXlPe9BaOLQNf+rRjQc0eg2DM8TyvZTs3mY6Xwy4xI2YLMGdIAAhTvD\nFWzuhKhZIHGKq9riF381rDtQho53\/Bjpboc1OiEJktMbtaplrbHboCOYT9rS\nOdhopocwgiRowOw6L0MNCKCBKjwA26IW9cRTXfE4i1vAlpUEHJze8XTXehvc\n2AQ05k3vDHaiDGNYeaPNoAzGxbwf\/86EHDCd4kbsyBMySII2NH92nevg4TbI\nA7ZVEGqiF93ocLb7nIdhgGMIoROW4Dvft2GHOqQiDoM3+YWJnT8O7yYL3fgI\nDwK+CrFX0lwBctUxtLH55qNd5xkYxMKvDffSn\/7b4L47JYQgjnW0XvZOv0L\/\nKmz\/BS5sIg5QvtkavDPlO\/Am+FzOBCBqgU8veEJA9LCBDRjQznIw3\/lJEIBs\n5gqhUIALN3rWR3QTh31IFwcUkAiV1QEOCH4ddw8LkAqpUH5cgAtnIGzikHgs\nxzSW1w3+Jgc0Bz32Rw8DoA3lQA8yIAP6xwoj4H\/\/B4BJYAOjoAZqYIDWRn0J\nuIB1Z3fHQAGdgHeJQIEcxwwLQH5csIHEQARE4C9aRx49oAPw5ydyIHaANUPE\nwXwtmH\/6Vw5iKIb\/F4DaoAGisAIroIM7WG0MR3pDd3qoJwjVQAEUAAdvEGAG\nsHcUgITFgAtLmIFNiAtQeAInMAa+UGwiyAEW8QMc\/\/AkgKUNx7EPkLOCLOiC\nNiADIzCDY0iDm2cHLxCKbNiGPueDcVh02McJ\/GWHjfABxyUJdigEfUiB+pAL\ndVAHX1B+uPCERHAChSAw8QAOHMaIE6EF3MAKkjiJxlGJljgC+UcPm7iJnch8\nDJAHoRiKaqiDBRgK01d9LDB0QFiHdmiH1YACSDCE4ziLsscIdRCIGriLhfiL\naxAPOKAKtbARPFAFQKKMywg5XuiC9ACN0TiNOwAAAHCNL5CN2siN3QiHcYhq\nwCAD6WiHomAJEzmO4LcGueCOG4gLf2OIAjOPOHCPEEFT\/KiMzKgNLigDABmN\nnKgL02aQB3mNCkmKB+iNCv+IBjI2Y+O4ihcZi063DcywkReYi04Yj\/ewBmuA\nAyRYEbAAAVVwkv3oj9rwgizJks4okCMwCI+ACqgwCQaJkGq4hm3IjW8YakPn\nCWxmhzz5kxfJd3iwkUx4lL0ojw\/QlAnxlG4glQYCOStplS8YkJuoCwnwCIY5\nCYgZljRJlqTYg9WnbTq3lm3plrGojrVWixuJgRpIDB95AgLTCCRYkjeVAXw5\nlfqXiVa5ks64QSVlmF8JljO5mAtplj4IdJE5YzpHmenYcXCwAHKJi7rIi74Y\nD7oQms1xU71QmpQ4AOVwmvoHmAH5ABcwna3pmompmAnJmDzIcGp5m2upmxMp\ni+f\/Zg9AIJeCeJSG+ACHAH8OwWyzoJyUCIOnCYOAKQP4wATTeQElVZio8AiI\nCZtiSZbbuHAIUAXemZu5CZ4YyQ250KAXeJ6c2YsCYIUYwWyZUADK6QoEwAfO\nOZ8yoANSwAT4SZ37eZjXGZtjOZshoAFQ8HAHOo6TCZ5CgAfluYS4OIhPGA8C\n4AXBtxBP+WXvWZrZ4ClhYAkdmokzgAkhKqIjqp+GaaIyGaAL+XDOEAEueqC4\nGaNuKQTWAAQ1OpceCQktcAgcYFuHJQc+wJfhADFpsAPhcJpewAZKKgVL2qTV\n2ZUnKptqMApJ8ADVZqVYKpkKaodwEAflaYvAuYFE4HIe\/8CIEWGhchCkJ7kE\nJQQAHGoDZcYGckqnTGqnhWmiALqYS5AEdGCAVmqgBvqiMqagquANX3qe8cCo\njpqX1iQHsAALaWogx5FkEBMO7URCmjqnTJqfJQql2LkClpAEwNCGahABapmq\nqqqgjAAE3uCgTFgC6tEIZVoRzCYHckBpJ+kBJoQA+xcCqrOpdeqpT\/qf2JkF\nSQAPOdiGLoqq0QqeVOCqDUp+RMBh+7atDgELX+atPJCPKOkAJmQJ7fRH54oJ\nc7qk+amfn+qfsAkAKqB5SeAFo7CGwBCo3smWlMkMQPaqyAAJi2AaKTBpECB5\nUdFlKJk6qoMK\/McHVsSwdFqnxP9aUv3JrgRghhcbCCswqp0XmdAamTtJmXHg\nqjWaCmqCIwJwsg\/RrSvLA6R5HDIAAyJAAJ3mKQQAAwxwC4Akp8Iqog9bna+5\nA2V4g+kUgM\/HZlUwtB2rparwYzWKB\/nzAG3QtBVaq1HxA5+wl8cBA1iABTCg\nCyGgsK7Af1lrReiariTKn6ggAmTIfDfIAJuntt7pth2bjnAABHKbC74ADi13\nByfLrQG7sp\/AA8dBD4EruIILAy0ABboAA66ATMHKqcMKsZ\/aCNMouWrbu2vb\nthw7kdUgt3VgP41WsinwEPzwb7NgqzzwA3xrCMYBuKu7ujBwvTBAAOYEtrbr\nqQkwg5z\/GLmVa7GWy7EJmo7ccGB4gAxp8i3SMLoNEXnOywOf8AmwsA\/aUL3V\ni726QELJtLi3W1ICWQ7SGLm+67tCi6UeSwGb8GOFkC1L+74uAbAq+7z1Sw0F\nwACXcAmBy8H6O7sLxb22O52k4IwD2Yk0SL69a763KWOJgAQLACnFBgl267Qy\nV8H0+wnUgAEb3MMbrL\/a+1SaWrNMSgpYqZUEPIY1qMICyMJtCQSB4wv2czjw\nC3mla8E6nAzcEA4+jAU\/HLiJG8IAbMRW6ZLgq8S8e8BOPGM4cDtSDLqboQD4\neMV8m8VXkAV47MMeDMJP9SmLiw82oAOpicThm8IHXL6BSgEn\/4AHhbAsaRLH\nMSG\/e3vBjojHWRADeowFg9DHEMO9DmADDjAK1ZCaLknAhZzGaoyl3IALXHAC\nMry0cjwR8juwz0sN1OBs3HDJlpwFl8DLvMrJnqKpUADKIUoKD1DGpVzAZ3vI\nWKoIxNDKr0yysRy\/dKzDP3BTChADunzJlxAOygDMJkQANlAGmMCk+CDI0KiV\nBYzGh9zEOmcDRPCEjEwlI3IACtARkmzB1JBRs9AN3KDN2mzJZQDOJRQGNmAH\nDSuiyhCYL2jGKIzKCMxmdwCFRMDIb9xo07y8V1y\/14wXVxADIA3QWRDEBF0t\nBi0CAOwKgDkCmmjGpzy+anwPvbjIJ\/\/gyBitvLNswRmVVewQ0iL9yyVt0PVA\nAIsLBfVJytK4zuXQzknADIZoiIVABNEsx8vWvN\/6vJRmU6vw0T4tsyWtOvxn\nA+EABQCgpID8gqh5lQ6dxGR4yIrgi78o01MdyVY9sJ+QCd+ARlmVzT490F8N\nMTEQ1gwQDiGwPh260i2dzJ3Yu8eAO\/fw2BVwD408w7UAEv9mqyubQBe1Q\/98\nCCA9A38NMSLAf4JtAyFw2Gnd0Il9wmKotm0Q10o5j41svFQtc\/M7CwmU1\/ZU\nC559CLrwC6FdLSFA2sR9pB5anw4dvlUZDyE5j\/SINKBb2RRx2ZldHUxyFxwQ\nA70d3NUCBa7\/QtyljdrIvdZj6AFKGQ\/oTY84YA8PnCb3ON11PQv0dN0QgA1X\noAuH4Fvc7SkIwABcC97hfdiIvdrgSwnOrd72QAkGDsHSnRDD57wS0g4NcAVb\ncN1bkAKHcAh+vd95cL3+DeABPp+pjcybeAnojQMobg8JTgmqQAlSrAjSHb8q\nOwvT0QDocOMTQAJ6UARk4M+HANr77SnY6+Egrn\/tdKTjHY2LkOIqruCq8OR2\n8MYk6ScqSyiGQAI3fuNRsOVRMAEKcAjAHeT+cARD\/t8g3k5HLuJHLQMMYA\/r\nreAsbhv48QCUYD8NDnmSR+MF0At\/YARGoOXoEAW8QAscMARhHNwh\/1DmHm7m\nxZ3mxw2Y1rDicY4ft\/EAlp4tlS3LkndD3ODnfp7lW14EW7AHYu4pg9C6Zc5\/\njE7a+4fkad3iTy7nlW4KtC4N9hAAU47nR1IAwtAMno4Of77labQHrVDqYWC9\nis61qx7i83kIsU7plk7rppAI1G4K0UCSDp4JbgAdJNAMvv7pOL4YViAPpe4P\n+pvsy87qrT6ftQHtiUPr1K4M+9EC9nDnlOYDg+EDf+Dt3\/7n6EALi0EL+VDu\nD4DsqI69ql7kjo4F7r4IpiAN8T7vjdAIdmDv74DvPsAN\/O7tv14EiUECUQAC\npV4G+ovsqf7hAH6a1jDr8E7tLaAbE+8FMv\/\/3n6S79MwBDuw7xzv6e2gGBMQ\nBadQ6gSABQ5AAA4gAodg8kOe8GduCu8O8S7\/8jHfH5\/HDiWRDH6QA9hwK4PB\nDfbyBLRAAtPxDbaw5X0g5mlwCXzsMwgABUdw8Aif7ocg7fEu9VP\/eUPwCmDw\nAzPxA+TgBxgQ+BBgMpUjKNQR6FEwB6WuDJdw6AAQuMnO9KQNI3UP8x0DQHoP\nBmBABnuxEH4f+KAP+LitPNNRDFq+DCN\/CSQt3Psb+fyXBZU\/8ZevA5mv+Zqf\nAz\/AED+gBeQA+r4f+DkAAShTBKAu8kFOAOFQDQV97oqu6o0g8TFP+7Vv+5Ug\nC9+q+1PQ+7\/\/+1n\/DwFF4O\/osAFiDgB4DNT+UPDWC\/lljgV23zF5b\/vwXwny\njw3f+hE\/kP1TsP36\/wxNABBNeEVBp87fQYQJFS5k2NBOjGoEwvxKSOASFowZ\nscDgyHFIo0ZehrwCU9JkyUopK8nKlIkHP379+P2YMoUcBpw5deZ8RohQE6Cn\nGg4lOnRGDKRZsoS7pMPSA6YXNWLsKJLkSZOVwKhMGSTTrJf9ZNKcomXKTrQY\nevr02cSIvKJxi6aJkaVuXaZMs1ziO5UqPawnuXK9AWEW2Jhja9pMuzMd27YW\nLNga10fuZYUPkdZdqpTv575YbJQbkCHw1sEpb9wQMstwWLFkbfppjJPc\/wTI\nhHhJ5r0BBGbMRzfb7ez5MwwbpTMsx5pa9eob2CBM5yETpmzGtTE8hrybN29b\nc1oBn6trc9K7nhmUy6BcOUrn0KHLcr0FQvWYMxdnb3w7t\/fvwFMiFvKG0uw8\n4kRLYjkGG0RtMPlWc+GGdyCwbwtYrOsHu7K0a+K\/AEO04K0CF8InBvPOg2GE\nKpZTrsHSUotwwgnnmW4LHGGBKbb9bMqhsSly082CW0QMkDLLSvQHFQFiOESX\nLGzQpkUY22swA8Lko9EFLqfBEcdvMhRrwx610OLHtJ5Rc01ahHnCzTeFkXNO\nOfWQkwQ6NNFzTz2X0GQJQAMVdJEYsBhBAyrbK\/9tgBcbrCTCG7bkkstvvvwm\nzPzI7JEcNLXDCYICQhXVkAIMMdWQd0x1Y9VdiuHGA1hjhfWQQzyg9dZDYmBg\nyioSVfRKFwfYZ8ZIJ3XhGhe83OLSSwEZU78ea+pUO2wK8MFaUUMl9dReDOll\n1VXbuYIZWWOl1dZDLpGhV3YZXLTR9vZhUMJijUX2mmveYRZcQDLlsCZOp21s\nCx+uLTjbbE\/11ttv3diFkSHKRReGcthtN1hgrdxH2Awk5fJefK+ZZ9lvVvXW\n2cT+ZSwHgdHCpmCYDb4WYVNL7baXbsN9FdYYbKDA4otddBdYeffZx9iPjw35\nmmlKNtnUfmXSNNqAW9b\/6eWYY8YWYW0V7tYQhxWAwwege61y6OXkbdDoSUFe\nWuR3wP3akKhjUtlHlqklG+YqsjaY620VNgQDMcQQouwrX3zR6KKFZfttyKtw\n+utQnRUL2mjLYjnvtLDpu9e9\/ZYZ8FK3maLwwn8OmlF3lWNc7df3gfzteaZZ\n+NTKx5y6RxJ69\/333mvBwHOLQ\/fhiR2SV34HS47hmnAafJ9gh3AaDMcB7LE\/\nIoPY441dhOzDz94VN3DPNmoeM5drAyfK7lWH34baYetVCidBIT6C5UMhB4r2\nn3FheSANRVGCwhBmObtlbgqXyYYNyuYFAMQFCtPwQf3spxAraGBRR+Af91wX\n\/zsPoCIuCCAV13yAMsWo7zIOaJHFSHEZHZABdWK4X0JoIAENLIeDCXFA2rgX\nuwG8MC6kKGGoZuaDTEhtd\/vBTBoyYLYqeAEzFpihGCagEBqIQQJVGMAOEdLD\n2L0uHJdBAMIOhsTELHExwLnS\/i6zAQlIQItWxKIccejGL\/4wjPvw4kHSQApA\nBhKQUDCiEWE2C93dTSEW2EMjaWABhbgnA3g8SAj4cElK+kMJWoyjBK6YECtw\nUgKZ7N8ejdZHfzjgGgNY5SpnZsisJXFHikwICTLBskzUECFtxJ\/FFKKETmrx\nkwixQiclYAX+mfKUCpnBEZzpzHpkS2Yxm0ViMNcjhf+QABs5uKUuD9KoTOaP\nQb80picxaExk8lCZfIxLNuBhrWnurZpjoiVCbAkBbnrTH2pbTjgZVAVyGnOY\nBylmJ9P5xXWOUS6WEB3ZqgmTazLxMk40WntQub3lbIOc7OjkQP1RUI4e9CCl\nfJ3jjCbEogDAE6KrAiKlVs+4gJF7GUDlDLLnUWCyg6Ps8GgxdyrSVK5zH\/WI\noARjZjFEQhSmRCEFg9SGSqIoQadT7alOJcAOoJJUmeFA6VBIETqk+ssPKizK\nDorxwx9CdShSvapOqzpVoO7ApMocgAdcIb74HeSroEOqEn8w1mgVRR0KyEEw\nKqoctTZEquzggFsVooepskP\/DwqZAAfmakpGvc4HXSXF54CWVLthALASRYhB\nFpmDd4QxsQxRQmNd61HITnWyCVHC9MTnCsY9U7dH4AM8spGQvVrsiRB4Fg\/8\ncFxsJmQDHvUHLQyhWsy01rXs2MFj2ZGC6862KKRgHGY6K9zlEPdyP8AJcteo\n3ClsQCHq0AF0QdkN+HbjlxygL31hO13tMrW7lwkB0BiUoR3x4EfmrYlCNjAF\nCRAoIWmwQexQqQcyxHe+9eXAfVOQAg7k16v7jQsAHGi2Bv0gUzyQQ05Ga+Cy\n0MBEDsZgN8gQ4QnXt7oJ0QOGOZACDTeEu0aTCwC80EKhDcAHMDGHWATMsuMC\nFsVl\/9GnP0Jg0kw24MUv\/qUTOGDlCj8WETfGsVx2vI+UzsATIFZUaTIRk3QY\n+ZYlFq0Ce5QJHBXgdU+MRCSwEYlVBCHPQZhyn7vhhD9fWdAc2DKhKXxhRCc6\n0Yi4LOPcl6hGVUFqc4gJLGaxufKO1s2VkrOj63znOkciCKMedZ+n7ARUp1rQ\niLAyIlyNYURcONaInrWs9ci4JyJOaFYawDzP8Q+ZwAICLckbgd08i290eh9V\nCIadQw3qO5Oa1H1GNRlSjeorO2HLruZ2rLudAm+Dm9Gxcx\/GXmSIMbnjH5W2\nzy2RbOzM+cENBRAWs0N9b3zXWdp8pra1r61tbXdb4N\/2Nv8i5gzeIJd5Gjui\nwT+AzQ9YVGrYnNO0Agm27GBkvNnNzje+921qf\/+b1QEfuMDFPe5lk\/lspUG3\nWKbQCofLBBBuwNEs3C3aikcrB2TTeM81HgmOd3zf\/PZ3yFPNaqSXfODF0EDK\nE9e6liZmCvJwOLD7AQhU2efSbG6zm7VgiG1ofBc+\/\/nGgZ7vbYw67aVux4v\/\nfXSSK53by\/HVrzIwDZTBBANUrzpMeAAIWASeB4P\/AQ9+cHjEJx7xWgDE5nLQ\neMdHXvKbg\/zkMZ23H\/1oFRjYPOc9v3nQ58Aw0xn9LACvO7HQAOZVf\/jl0ii1\nHcXe9bPX3euftaPL5R71tIf97nsy7\/o0WlP2r4\/JOU7B+r5nqva7jz1EdZ97\n4qNe+bonfvCfVXvly1762beOOdLBd+Q7PCAAOw==\n",
            "filename" => "rails_logo.gif"
        ]
        ]);
        return $this->renderText(json_encode($test));
    }

    /**
     * dữ liệu gửi lên từ ảnh phải là từng rq 1
     * @return string
     * @throws \Haravan\HaravanApiException
     */
    public function executeSendProductHaravan()
    {
        $client = new HaravanClient('itemd-shop.myharavan.com', 'Z_M_Nn7GSZShgErXXegACIfIIYotQCPvTaQwe1Px3Dslz3YBsXseUa9nWEoI55rXafj_ziKu7aOwSRRhGUIxJermcAMfdaBwuLgdk5x5XItDlnIMUzUM16yozqYcuVH4ifddvBKcAS6LCXnoRbKBZX1zvyH0kzf43DGIs_uOZwdRDLYO74NsK02wMnt5gz17VWIKjrwED01vvyNyddzwrWU1J7ViZ8dZLJnGCqXh9He1v-r0ZcOmiGpuVxou43KPQ_9HFs-Gw5S_FLMO1FIu7FVHUbrpxr2lAi0sNKInf1S9QG9A_eJENoYwSlPdoGdOjOBK-fpI0g4nbnr4tzQ4f_2HhfDccQciEgZ6dfr_cx3xmlr5Zc6SpPOuks9JuLgmEVYuiTvVuuygI03_GoR9nQPEudbbUHnPo_EtzwTeatBjUrTA7Uau2-u1zBfm4UfiJXOobUFwQWumcdT2xQV_f214kMckrrvztO9IzBOQUWE2r8ErX_WAGXDyU0a7bHsyNSHstA');
        $test = $client->call('POST', '/admin/products.json', ["product" => [
            "title" => "Burton Custom Freestlye 151333",
            "body_html" => "<strong>Good snowboard version 23<\/strong>",
            "vendor" => "Burtonwwww",
            "product_type" => "Snowboardwwwww",
            "tags" => "Barnes & Noble, John's Favwww, \"Big Air\"",
            "images" => [
                [
                    #"attachment" => "R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==\n",
                    "src" => "http://example.com/rails_logo.gif"
                ],
                [
                    "src" => "http://www.12cunghoangdao.com.vn/wp-content/uploads/2015/09/tu-vi-12-cung-hoang-dao-thu-ba-ngay-15-9-2015.jpg"
                ]

            ]
        ]
        ]);

        return $this->renderText(json_encode($test)); // lưu lại giá trị id của sản phẩm
    }

    /**
     *hàm chuyển đổi qua lưu giá trị từ chuỗi thành mảng
     */
    public function executeChangeTags(){
        $conditionProduct = [];
        $mandango = ConnectMongoDB::getConnection();
        $itemRepo = new ItemsRepository($mandango);
        $items = $itemRepo->createQuery()
            ->criteria($conditionProduct)
            ->all();
        foreach($items as $item){
            /** @var \Mongodb\Items $item */
            if($item->getTags()){ //nếu có tag thì chuyển tag sang lưu dưới dạng mảng của key
                $arrTag = explode(',',$item->getTags());
                $item->setTagsProduct($arrTag);
                $item->save();
            }
        }
    }


}