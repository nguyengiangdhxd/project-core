<?php
/**
 * Created by PhpStorm.
 * User: luuhieu
 * Date: 12/24/15
 * Time: 11:43
 */

namespace Customer\Controller;


use Flywheel\Queue\Queue;
use Mongodb\ConnectMongoDB;
use Mongodb\Items;
use Mongodb\ItemsRepository;

class Synchronized extends CustomerBase
{
    public function executeDefault() {
        //do nothing
    }

    public function executeSync() {
        $ajax = new \AjaxResponse();
        $items_id = $this->request()->get('items_id', 'ARRAY', []);
        $repo = new ItemsRepository(ConnectMongoDB::getConnection());
        /** @var \MongoDb\Items[] $items */
        $items = $repo->findById($items_id);
        $queue = Queue::factory('integration_synchronized');

        $qid = [];
        $fail_ids = [];
        $success_ids = [];
        foreach($items as $item) {
            //check owner
            if ($item->getCustomerId() != $this->customerLogin()->getId()) {
                $ajax->type = \AjaxResponse::ERROR;
                $ajax->message = 'Sản phẩm .' .$item->getId()->{'$id'} .' không thuộc sở hữu của bạn';
                return $this->renderText($ajax->toString());
            }
            //update sync process flag
            $item->setSyncProcess(true);
            $item->save();

            if($item->getIsActive() == Items::ACTIVE){ // nếu sp có isAcitive là acitve thì mới cho vào mảng
                $qid[] = $item->getId()->{'$id'};
                $success_ids[] = $item->getId()->{'$id'};
            }else{
                // mảng lưu trữ id ko đủ điều kiện
                $fail_ids[] = $item->getId()->{'$id'}; // nếu sp ko đủ đk thì add vào trong mảng lỗi
            }

        }

        for($i = 0, $size = sizeof($qid); $i < $size; ++$i) {
            $queue->push($qid[$i]);
        }

        $ajax->message_error = sizeof($fail_ids).' sản phẩm ko đủ điều kiện đồng bộ !' ;
        $ajax->message_success = sizeof($success_ids) .' sản phẩm đã được thêm vào danh sách đồng bộ!';
        $ajax->type = \AjaxResponse::SUCCESS;
        return $this->renderText($ajax->toString());
    }
}