<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/21/2016
 * Time: 9:53 AM
 */

namespace Haravan;


use Flywheel\Db\Type\DateTime;

class HaravanService {
    const HARAVAN_KEY = 'HARAVAN';

    /**
     * truyền vào đối tượng mà một items
     * xử lý convert sang dữ liệu chuẩn của haravan gửi lên
     * TODO : dữ liệu chuẩn của haravan
     * @param \Mongodb\Items $item
     */
    public function syncItem($item){
        // trả ra một đối tượng của product


    }

    /**
     * Lấy về setting của khách hàng với haravan; nếu khách hàng chưa có đủ store và access_token thì trả về false tức
     * khách hàng chưa cài đặt
     * @param \Customer|int $customer
     * @return bool|array
     * @throws \Exception
     * @author kiennx
     */
    public static function getCustomerSettings($customer) {
        if (is_int($customer)) {
            $customer_id = $customer;
        }

        if ($customer instanceof \Customer) {
            $customer_id = $customer->getId();
        }

        if (!isset($customer_id)) {
            throw new \Exception('$customer must be int or Customer object');
        }

        $profiles = \Mongodb\CustomerProfilesRepository::findOneOrCreateByCustomerId($customer_id);
        $integration = $profiles->getIntegration();
        if (!is_array($integration)) {
            return false;
        }

        if (isset($integration['haravan'])) {
            $settings = $integration['haravan'];

            if (!is_array($settings)) {
                return false;
            }

            if (!isset($settings['store']) || !isset($settings['access_token'])) {
                return false;
            }

            return $settings;
        };

        return false;
    }

    /**
     * Cài đặt app haravan cho customer
     * @param $customer
     * @param $store
     * @param $access_token
     * @return array
     * @throws \Exception
     */
    public static function install($customer, $store, $access_token) {
        if (is_int($customer)) {
            $customer_id = $customer;
        }

        if ($customer instanceof \Customer) {
            $customer_id = $customer->getId();
        }

        if (!isset($customer_id)) {
            throw new \Exception('$customer must be int or Customer object');
        }

        $profiles = \Mongodb\CustomerProfilesRepository::findOneOrCreateByCustomerId($customer_id);
        $integration = $profiles->getIntegration();
        if (!is_array($integration)) {
            $integration = [];
        }

        if (!isset($integration['haravan'])) {
            $settings = [];
        }
        else {
            $settings = $integration['haravan'];
        }
        $settings['createdTime'] = new \MongoDate(strtotime(new DateTime()));

        $settings['store'] = $store;
        $settings['access_token'] = $access_token;

        $integration['haravan'] = $settings;
        $profiles->setIntegration($integration);
        $profiles->save();

        return $settings;
    }

    static $_clients = [];
    /**
     * trả về client của haravan khi đông bộ
     * @param $customer_id
     * @throws \Exception
     * @return \BizWeb\BizWebClient
     */
    public static function createClient($customer_id) {
        if (isset(self::$_clients[$customer_id])) {
            return self::$_clients[$customer_id];
        }

        $settings = HaravanService::getCustomerSettings($customer_id); // đối tượng cusotomer

        if ($settings) {
            $storeCustomer = $settings['store'];
            $customerAccess = $settings['access_token'];
            $client = new HaravanClient($storeCustomer, $customerAccess);
            self::$_clients[$customer_id] = $client;
            return $client;
        }

        throw new \Exception("Customer is not install Haravan App yet");
    }
    #endregion
}