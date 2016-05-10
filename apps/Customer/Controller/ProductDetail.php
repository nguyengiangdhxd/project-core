<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2/17/2016
 * Time: 4:22 PM
 */

namespace Customer\Controller;


use Comment\ItemsActivityLogger\ItemsLog;
use Core\Common;
use Core\CustomerAuth;
use Flywheel\Exception;
use Mongodb\ConnectMongoDB;
use Mongodb\ItemsCommentRepository;
use Mongodb\ItemsRepository;
use Mongodb\ItemVariantRepository;

class ProductDetail extends CustomerBase{

    public function executeDefault()
    {
        $this->setLayout('default');  // đã xét nmsgu
        /*$this->setView( 'Product/list' );*/
        $this->setView( 'Product/product_detail' );
        $this->document()->title = 'Chi tiết sản phẩm';

        $product_id = $this->request()->get('id'); // id này có thể là của sản phẩm
        $store = $this->request()->get('store'); // store của người dùng
        $app_key = $this->request()->get('app_key'); // app key có thể là bizweb hoặc haravan
        $array_data = []; // chứa giá trị của
        $itemProduct = $this->_getInfoProduct($product_id,$app_key,$store);
        if($itemProduct instanceof \Mongodb\Items){
            $item_variant = $itemProduct->getVariants();
            $array_data['item_variant'] = $item_variant;
        }

        $this->_items = $itemProduct; // cho vào biến tạm
        $array_data['item_product'] = $itemProduct;

        $this->view()->assign(
            $array_data
        );

        $this->document()->addJsVar('product_id', $product_id);
        $this->document()->addJsVar('app_key', $app_key);
        $this->document()->addJsVar('store', $store);
        $this->document()->addJsVar('item_options', $itemProduct->getOptions()); // lấy lại mảng option

        return $this->renderComponent();
    }

    /**
     * Đầu vào trang có thể từ trang quản trị của bizweb hoặc từ trang ds của sản phẩm
     * hàm lấy thông tin của sản phẩm để hiển thị , trả về items
     * @param $productId : có thể là id của mongo hoặc id của bizweb trả về
     * @param null $app_key
     * @param null $store
     * @return \Mandango\Document\Document|null
     */
    private function _getInfoProduct($productId, $app_key, $store){
        try{
            $itemRepo = new ItemsRepository(ConnectMongoDB::getConnection());
            $mandango = ConnectMongoDB::getConnection();
            #$itemProduct = $itemRepo->findOneById($productId);
            if(!\MongoId::isValid($productId)){ // trong trường hợp nếu sản phẩm ko lấy được theo id của mongodb
                $conditionProduct = [];
                $conditionProduct['integration'] = ['$exists' => true];
                if($app_key && $store){
                    $conditionProduct['integration.'.strtolower($app_key).'.store'] = $store;
                }
                $customerRepo = new \Mongodb\CustomerProfilesRepository($mandango);
                $customerProfile = $customerRepo->createQuery()
                    ->criteria($conditionProduct)->one();
                /** @var \Mongodb\CustomerProfiles $customerProfile*/
                if(!$customerProfile){
                    $this->redirect($this->raise404());
                    return;
                }
                $customer_id = $customerProfile->getCustomerId();
                #################phần lấy giá trị của sản phẩm theo variant#########################
                $conditionalItem = [];
                $conditionalItem['integrationItemVariants'] = ['$exists' => true];
                $conditionalItem['integrationItemVariants.'.$app_key.'.variant_id'] = $productId; // ko lấy được $app_key



                $itemVariantRepo = new \Mongodb\ItemVariantRepository($mandango);
                $item_variant = $itemVariantRepo->createQuery()
                    ->criteria($conditionalItem)
                    ->one();
                if($item_variant){
                    /** @var \Mongodb\ItemVariant $item_variant */
                    $itemId = $item_variant->getItemId();
                    $repoItem = new ItemsRepository(ConnectMongoDB::getConnection());
                    $itemProduct = $repoItem->findOneById($itemId);
                    /** @var \Mongodb\Items $itemProduct */
                    return $itemProduct;

                }else{ // lấy gia trị theo Items
                    $conditionProduct = [];
                    $conditionProduct['integrationItems'] = ['$exists' => true];
                    $conditionProduct['integrationItems.'.$app_key.'.product_id'] = $productId;
                    $conditionProduct['customerId'] = $customer_id;

                    $itemRepo = new ItemsRepository($mandango);
                    $items = $itemRepo->createQuery()
                        ->criteria($conditionProduct)
                        ->one();
                    if($items){
                        return $items;
                    }else{
                       $this->redirect($this->raise404());
                    }
                }
            }else{
                return $itemRepo->findOneById($productId);
            }
        }catch (Exception $e){
           return $e;
        }

    }

    /**
     * dùng trong trường hợp khung dưới
     * phương thức trả về đói tượng
     */
    public function executeGetItemProduct(){
        $product_id = $this->request()->get('id');
        $active = $this->request()->get('active'); // trạng thái của sản phẩm
        $app_key = $this->request()->get('app_key');
        $store = $this->request()->get('store');

        try{
            $item_product = $this->_getInfoProduct($product_id,$app_key,$store);
            $ajax = new \AjaxResponse();
            if($active == 'true'){
                /**@var \Mongodb\Items $item_product */
                $item_product->setIsActive('ACTIVE');
                $item_product->save();
            }elseif($active == 'false'){
                /**@var \Mongodb\Items $item_product */
                $item_product->setIsActive('INACTIVE');
                $item_product->save();
            }
            $arr_data = $item_product->toArray() ;

            $arr_integration = self::getIntegration($item_product);
            $arr_data = array_merge($arr_data,$arr_integration);

            $ajax->type = \AjaxResponse::SUCCESS;
            $ajax->message = "Thành công";
            $ajax->data = $arr_data; // trả về mảng giá trị
            return $this->renderText($ajax->toString());
        }catch (Exception $e){
            return $e->getMessage();
        }
    }


    /**
     * @param \Mongodb\Items $itemProduct
     * @return array
     */
    private static function getIntegration($itemProduct){
        $tmp_data = [];
        if($itemProduct->getIsActive() == 'ACTIVE'){
            $tmp_data['is_active'] = true;
        }
        if($itemProduct->getIntegrationItems()){
            $inter = $itemProduct->getIntegrationItems();
            $tmp_data['had_sys'] = true; // nếu đã được đồng bộ thì giá trị sẽ bằng true
            foreach($inter as $key => $val){
                if($key == "BIZWEB"){
                    $tmp_data['server_sys'] = 'Bizweb';
                }
                if($val['status'] == 'FAILED'){
                    $tmp_data['status_sys'] = 'Thất bại';
                    $tmp_data['approval_status_fail'] = true;
                }elseif($val['status'] == 'SUCCESS'){
                    $tmp_data['status_sys'] = 'Thành công';
                    $tmp_data['approval_status_success'] = true;
                    $tmp_data['bizweb_id'] = $val['product_id'];
                }
                $tmp_data['time_sys'] = date('H:i d/m/Y',$val['last_sync']->sec);
            }
        }
        return $tmp_data;
    }

    /**
     * hàm trả về dữ liệu render trang và lưu lại giá của variant
     * @return string
     */
    public function executeGetVariantFollowId(){
        $product_id = $this->request()->post('id');
        $variant_id = $this->request()->post('variant_id');
        $app_key = $this->request()->post('app_key');
        $store = $this->request()->post('store');
        $sale_price = $this->request()->post('sale_price');// giá bán của sản phẩm
        try{
            $item_product = $this->_getInfoProduct($product_id,$app_key,$store);
            if(\MongoId::isValid($variant_id) && $sale_price){
                $repo = new ItemVariantRepository(ConnectMongoDB::getConnection());
                $item_variant = $repo->findOneById($variant_id);
                /** @var \Mongodb\ItemVariant $item_variant */
                $variant_price = Common::moneyToFloat($sale_price);
                $item_variant->setSalePrice($variant_price); // lưu lại giá trị của giá vừa cập nhật
                $item_variant->save();
                \Mongodb\Items::updatePriceFromVariant($item_product); // cập nhật lại giá hiển thị
            }
            /** @var \Mongodb\Items $item_product */
            $arr_data = $this->_getItemVariants($item_product);
            $ajax = new \AjaxResponse();
            $ajax->type = \AjaxResponse::SUCCESS;
            $ajax->message = "Thành công";
            $ajax->data = ['list_variant' => $arr_data]; // trả về mảng giá trị
            return $this->renderText($ajax->toString());
        }catch (Exception $e){
            return $e->getMessage();
        }

    }
    /**
     * hàm lấy giá trị của variant theo item
     * @param \Mongodb\Items $item
     * @return array
     */
    private function _getItemVariants($item){
        $mandango = ConnectMongoDB::getConnection();
        $conditional = [];
        $conditional['itemId'] = $item->getId()->{'$id'};
        $itemVariantRepo = new \Mongodb\ItemVariantRepository($mandango);
        $list_item_variant = $itemVariantRepo->createQuery()
            ->criteria($conditional)
            ->all()
        ;
        $homeLand = $item->getHomeLand();

        $list_variants = [];
        foreach($list_item_variant as $variant){
            /**@var \Mongodb\ItemVariant $variant*/
            $variantArray = $variant->toArray();
            $variantArray['homeLand'] = $homeLand;
            if($homeLand == '1688'){
                $isHomeLand = true;
                $variantArray['isHomeLand'] = $isHomeLand;
                $variantArray['minPriceOrigin'] = $item->getMinOriginPrice();
                $variantArray['maxPriceOrigin'] = $item->getMaxOriginPrice();
            }
            if($variant->getOriginalSalePrice()){
                $variantArray['has_sale_price'] = true;
            }
            $list_variants[] = $variantArray;

        }
        return $list_variants;
    }

    /**
     * hàm update lại option cho sản phẩm
     * @return string
     */
    public function executeUpdateOptionProduct(){
        $product_id = $this->request()->post('id');
        $app_key = $this->request()->post('app_key');
        $store = $this->request()->post('store');
        $options = $this->request()->post('option','ARRAY',[]);
        try{

            $item_product = $this->_getInfoProduct($product_id,$app_key,$store);
            /**@var \Mongodb\Items $item_product*/
            if(count($options) > 0){
                $item_product->setOptions($options);
                $item_product->save();
            }
            $ajax = new \AjaxResponse();
            $ajax->type = \AjaxResponse::SUCCESS;
            $ajax->data = $item_product->toArray();
            $ajax->message = 'Thành công !';
            return $this->renderText($ajax->toString());
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * hàm thực hiện lưu lại các đoạn chat và trả lại ngay lập tức cho người dùng
     */
    public function executeLoadAndUpdateActivity(){
        $user_id = CustomerAuth::getInstance()->getCustomer()->getId();
        $user_name = CustomerAuth::getInstance()->getCustomer()->getName();
        $product_id = $this->request()->post('id'); // id của product
        $app_key = $this->request()->post('app_key');
        $store = $this->request()->post('store');
        $content_chat = $this->request()->post('content'); // nội dung chat
        ## lấy dữ liệu
        try{
            $item_product = $this->_getInfoProduct($product_id,$app_key,$store);
            if($content_chat && $item_product){
                // lưu lại nội dung chat ở đây
                ItemsLog::logChatItem($item_product,$user_id,$content_chat);
            }
            $item_product_id = $item_product->getId()->{'$id'};
            $conditional = [];
            $conditional['createdBy'] = "$user_id";
            $conditional['idItems'] = $item_product_id;
            $conditional['$or'] = [['contextType' =>'ACTIVITY'],['contextType' => 'CHAT']];
            $itemComment_Repo = new ItemsCommentRepository(ConnectMongoDB::getConnection());
            $item_comments = $itemComment_Repo->createQuery()
                ->criteria($conditional)
                ->sort(['createdTime' => -1])
                #->skip(1) // bắt đầu lòa từ trang
                ->limit(100)
                ->all();
            $list_comment = [];

            foreach($item_comments as $item_comment){
                /** @var \Mongodb\ItemsComment $item_comment */
                $arr_comment = $item_comment->toArray();
                if($item_comment->getContextType() == 'CHAT'){
                    $arr_comment['is_chat'] = true;
                }
                $arr_comment['user_name'] = $user_name;
                $arr_comment['display_createTime'] = $item_comment->getCreatedTime()->format('d/m/Y H:i:s');
                $list_comment[] = $arr_comment;
            }
            $ajax = new \AjaxResponse();
            $ajax->type = \AjaxResponse::SUCCESS;
            $ajax->data = ['list_comments' => $list_comment];
            return $this->renderText($ajax->toString());
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

}