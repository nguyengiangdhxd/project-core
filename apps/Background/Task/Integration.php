<?php
/**
 * Created by PhpStorm.
 * User: luuhieu
 * Date: 12/24/15
 * Time: 11:57
 */

namespace Background\Task;


use Core\Event\ItemsEvent;
use BizWeb\BizWebClient;
use BizWeb\BizWebService;
use Core\CustomerAuth;
use Core\GlobalEventDispatcher;
use Core\IntergrationApp\Factory;
use Core\Logger;
use Flywheel\Queue\Queue;
use Mongodb\ConnectMongoDB;
use Mongodb\ItemsRepository;
use SeuDo\Common\RedisCache;

class Integration extends BackgroundBase
{
    const APP_KEY = 'BIZWEB';
    public function executeSyncItems() {
        $queue = Queue::factory('integration_synchronized');
        $this->doQueue($queue, 10, function($item_id) {
            $logger = Logger::factory('synchronized');
            $repo = new ItemsRepository(ConnectMongoDB::getConnection());
            /** @var \MongoDb\Items $item */
            $item = $repo->findOneById($item_id);
            if (!$item) {
                $logger->error('item not found with id:' .$item_id);
                return;
            }else{
                //foreach integration lay ra adapter phu hop voi no roi goi den ham sync
                // nội dungappkey là do đối tượng custmwr cài đăt truyteenf vào
               /* $customer_id = $item->getCustomerId();
                $profiles = \Mongodb\CustomerProfilesRepository::findOneOrCreateByCustomerId($customer_id);
                foreach($profiles as $app_key => $value){ // lặp ra dữ liệu gửi lên
                    $app = Factory::createApplication(strtoupper($app_key)); // chuyển chữ thường thành chữ hoa
                    $app->sync($item);
                }*/
                $client = BizWebService::createClient($item->getCustomerId());
                $server = new BizWebService($client);
                $server->syncItem($item);
                // đoạn này cần chủ động log lại xem là do haravan hay do bizweb đồng bộ lên trên web dịch vụ
                GlobalEventDispatcher::getInstance()->dispatch('afterBackgroundSysItem', new ItemsEvent(null, [
                    'item' => $item,
                    'app_key' => self::APP_KEY
                ]));
            }
        }, function(){
            return (BizWebClient::$countCallRequest > 100) || ($this->processed > 100);
        });
    }
}