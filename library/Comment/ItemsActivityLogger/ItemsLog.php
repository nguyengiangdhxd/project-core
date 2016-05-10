<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2/24/2016
 * Time: 9:50 AM
 */
namespace Comment\ItemsActivityLogger;
class ItemsLog {


    /**
     * @param $item \Mongodb\Items
     * @param int $actionBy
     * @param string $specialContext
     * @param array $additionalContext
     */
    public static function logItemSysFromSource($item, $actionBy = 0, $specialContext = "", $additionalContext = []){
        $action_name = "Đồng bộ sản phẩm từ nguồn";
        $action_context = "có ID ".$item->getId()->{'$id'};
        self::_writeLog($item, $actionBy, $action_name, $action_context.$specialContext, $additionalContext);

    }

    public static function logChatItem($item, $actionBy = 0, $specialContext = "", $additionalContext = []){
        $action_name= null;
        $action_context = null;
        $is_chat = 'CHAT';
        self::_writeLog($item, $actionBy, $action_name, $action_context.$specialContext, $additionalContext , $is_chat);
    }

    /**
     * ghi lại hành động của khách khi đồng bộ sản phẩm lên web dịch vụ
     * là Bizweb hay haranvan
     * @param \Mongodb\Items $item
     * @param int $actionBy
     * @param string $specialContext
     * @param array $additionalContext
     */
    public static function logItemSys($item, $actionBy = 0, $specialContext = "", $additionalContext = [])
    {
        $action_name = "Đồng bộ sản phẩm";
        $action_context = "có ID ".$item->getId()->{'$id'}." lên ";
        self::_writeLog($item, $actionBy, $action_name, $action_context.$specialContext, $additionalContext);
    }


    // viết thêm log xóa và xuất
    /**
     * @param $item \Mongodb\Items
     * @param $actionBy
     * @param $action_name
     * @param $action_context
     * @param $additionalContext
     * @param null $is_chat
     */
    private static function _writeLog($item, $actionBy, $action_name, $action_context, $additionalContext , $is_chat = null)
    {
        if ($actionBy > 0) {
            if($is_chat){
                $context = new \Comment\Context\Chat();
            }else {
                $context = new \Comment\Context\Activity();
            }
            foreach ($additionalContext as $k => $v) {
                $context->$k = $v;
            }

            \Comment\ActivityLogger\ItemsComment::createActivity($actionBy, $action_name,
                " $action_name $action_context", $item, $item->getId(), $context->toArray());
        } else {

            $context = new \Comment\Context\Logging();


            foreach ($additionalContext as $k => $v) {
                $context->$k = $v;
            }
            $action_name = ucfirst($action_name);
            \Comment\ActivityLogger\ItemsComment::createLog($action_name, "$action_name $action_context.", $item, $item->getId(), $context->toArray());
        }
    }
}